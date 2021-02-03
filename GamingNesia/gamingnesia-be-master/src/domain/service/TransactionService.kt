package com.warungsoftware.domain.service

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.repository.PaymentRepository
import com.warungsoftware.domain.repository.TransactionDetailRepository
import com.warungsoftware.domain.repository.TransactionRepository
import com.warungsoftware.ext.*
import domain.model.*
import ext.toTransactionWrapper
import java.util.*

class TransactionService (
    private val transactionRepository: TransactionRepository,
    private val paymentRepository: PaymentRepository,
    private val transactionDetailRepository: TransactionDetailRepository
) {

    fun create(transactionRequest: TransactionRequest): TransactionWrapper? {
        var transactionId: UUID = UUID.randomUUID()

        paymentRepository.create(
            transactionRequest.mapToPayment()
        )?.also { paymentId ->
            transactionRepository.create(
                transactionRequest.mapToTransaction(paymentId)
            )?.also { id ->
                transactionId = id
                transactionDetailRepository.batchCreate(
                    transactionRequest.products.map {
                        it.mapToTransactionDetail(id)
                    }
                )
            }
        }

        val transactionDetail = transactionDetailRepository.findByTransaction(transactionId)

        return transactionRepository
            .findTransactionBy(transactionId)
            ?.toTransactionWrapper(transactionDetail)

    }

    fun findAll(): List<TransactionWrapper> {

        val transactions = transactionRepository.findAll()

        val transactionWrappers = mutableListOf<TransactionWrapper>()

        transactions.forEach {
            it.id?.let { transactionId ->
                val transactionDetail = transactionDetailRepository.findByTransaction(transactionId.toUUID())
                transactionRepository.findTransactionBy(transactionId.toUUID())?.toTransactionWrapper(transactionDetail)?.let { transactionWrapper ->
                    transactionWrappers.add(transactionWrapper)
                }
            }
        }

        return transactionWrappers

    }

    fun findById(id: UUID): TransactionWrapper? {

        val transactionDetail = transactionDetailRepository.findByTransaction(id)

        return transactionRepository.findTransactionBy(id)?.toTransactionWrapper(transactionDetail).apply {
            require(this?.id != null ) { throw NotFoundException("Transaction not found")}
        }
    }

    fun update(id: UUID, status: Int): TransactionWrapper? {

        val transactionDetail = transactionDetailRepository.findByTransaction(id)

        return transactionRepository.updateStatus(id, status)?.toTransactionWrapper(transactionDetail).apply {
            require(this?.id != null ) { throw NotFoundException("Transaction not found")}
        }

    }

    fun findByBuyer(buyerId: String): List<TransactionWrapper>? {
        require(buyerId.isUUIDValid()) { throw InvalidRequestException("Id is not valid") }
        val transactions = transactionRepository.findByBuyer(buyerId.toUUID())

        val transactionWrappers = mutableListOf<TransactionWrapper>()

        transactions.forEach {
            it.id?.let { transactionId ->
                val transactionDetail = transactionDetailRepository.findByTransaction(transactionId.toUUID())
                transactionRepository.findTransactionBy(transactionId.toUUID())?.toTransactionWrapper(transactionDetail)?.let { transactionWrapper ->
                    transactionWrappers.add(transactionWrapper)
                }
            }
        }
        
        return transactionWrappers
    }

    fun findBySeller(sellerId: String): List<TransactionWrapper> {
        require(sellerId.isUUIDValid()) { throw InvalidRequestException("Id is not valid") }

        return transactionRepository.findBySeller(sellerId.toUUID())
    }

}