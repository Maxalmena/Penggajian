package com.warungsoftware.domain.repository

import com.google.gson.Gson
import com.warungsoftware.domain.model.PaymentMethods
import com.warungsoftware.ext.toUUID
import domain.model.*
import domain.model.Transaction
import ext.toTransactionDetailModel
import ext.toTransactionDetailWrapper
import ext.toTransactionModel
import ext.toTransactionWrapper
import org.jetbrains.exposed.sql.*
import org.joda.time.DateTime
import org.jetbrains.exposed.sql.transactions.transaction as exposeTransaction
import java.util.*

class TransactionRepositoryImpl : TransactionRepository {
    override fun create(transaction: Transaction): UUID? {
        return exposeTransaction {
            Transactions.insert { row ->
                row[paymentId] = transaction.paymentId.toUUID()
                row[date] = DateTime.now()
                row[status] = transaction.status
                row[totalPrice] = transaction.totalPrice
                row[userId] = transaction.userId.toUUID()
                row[adminFee] = transaction.adminFee
                row[uniqueCode] = transaction.uniqueCode
            }.getOrNull(Transactions.id)
        }
    }

    override fun findBy(id: UUID): Transaction? {
        return exposeTransaction {
            Transactions
                .select{ Transactions.id eq id }
                .map {
                    it.toTransactionModel()
                }
                .firstOrNull()
        }
    }

    override fun findTransactionBy(id: UUID): ResultRow? {
        return exposeTransaction {
            Transactions
                .innerJoin(Payments, {this.paymentId}, {Payments.id})
                .innerJoin(PaymentMethods, {Payments.method}, {PaymentMethods.id})
                .select { Transactions.id eq id }
                .firstOrNull()
        }
    }

    override fun findAll(): List<Transaction> {
        return exposeTransaction {
            Transactions.selectAll().map {
                it.toTransactionModel()
            }
        }
    }

    override fun updateStatus(id: UUID, status: Int): ResultRow? {
        return exposeTransaction {
            Transactions.update({Transactions.id eq id}) { row ->
                row[Transactions.status] = status
            }

            findTransactionBy(id)
        }
    }

    override fun findByBuyer(buyerId: UUID): List<Transaction> {
        return exposeTransaction {
            Transactions.select{Transactions.userId eq buyerId}
                .map {
                    it.toTransactionModel()
                }
        }
    }

    override fun findBySeller(sellerId: UUID): List<TransactionWrapper> {
        return exposeTransaction {
            val resultRow = Transactions
                .innerJoin(TransactionDetails, {Transactions.id}, {TransactionDetails.transactionId})
                .innerJoin(Products, {TransactionDetails.productId}, {Products.id})
                .innerJoin(Promos, {TransactionDetails.productId}, {Promos.productId})
                .select { Products.userId eq sellerId }

            val transactions =  resultRow.map {
                it.toTransactionModel()
            }


            val transactionsDistinct = transactions.distinctBy { it.id }


            val transactionDetails = resultRow.map {
                it.toTransactionDetailWrapper()
            }


            val transactionWrappers = mutableListOf<TransactionWrapper>()

            transactionsDistinct.forEach {
                val td = transactionDetails.filter { trd ->
                    trd.transactionId == it.id
                }
                transactionWrappers.add(findTransactionBy(it.id!!.toUUID())!!.toTransactionWrapper(td))
            }

            transactionWrappers

        }
    }

}