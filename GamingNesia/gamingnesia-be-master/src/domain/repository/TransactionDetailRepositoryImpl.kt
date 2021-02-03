package com.warungsoftware.domain.repository

import com.warungsoftware.ext.toUUID
import domain.model.*
import ext.toTransactionDetailModel
import ext.toTransactionDetailWrapper
import org.jetbrains.exposed.sql.*
import org.jetbrains.exposed.sql.transactions.transaction
import java.util.*

class TransactionDetailRepositoryImpl : TransactionDetailRepository {
    override fun batchCreate(transactionDetail: List<TransactionDetail>): List<TransactionDetail> {
        return transaction {
            TransactionDetails.batchInsert(transactionDetail){ insertTransactionDetail ->
                this[TransactionDetails.productId] = insertTransactionDetail.productId.toUUID()
                this[TransactionDetails.quantity] = insertTransactionDetail.quantity
                this[TransactionDetails.remarks] = insertTransactionDetail.remarks
                this[TransactionDetails.transactionId] = insertTransactionDetail.transactionId.toUUID()
            }.map {
                it.toTransactionDetailModel()
            }
        }
    }

    override fun findByTransaction(transactionId: UUID): List<TransactionDetailWrapper> {
        return transaction {
            TransactionDetails
                .innerJoin(Products, {TransactionDetails.productId}, {Products.id})
                .innerJoin(Promos, {TransactionDetails.productId}, {Promos.productId})
                .select {
                TransactionDetails.transactionId eq transactionId
            }.map {
                it.toTransactionDetailWrapper()
            }
        }
    }

    override fun findBySellerId(transactionId: UUID, sellerId: UUID): List<TransactionDetailWrapper> {
        return transaction {
            TransactionDetails
                .innerJoin(Products, {TransactionDetails.productId}, {Products.id})
                .select {
                    TransactionDetails.transactionId eq transactionId and (Products.userId eq sellerId)
                }.map {
                    it.toTransactionDetailWrapper()
                }
        }
    }
}