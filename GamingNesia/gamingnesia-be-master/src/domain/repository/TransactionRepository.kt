package com.warungsoftware.domain.repository

import domain.model.Transaction
import domain.model.TransactionWrapper
import org.jetbrains.exposed.sql.ResultRow
import java.util.*

interface TransactionRepository {
    fun create(transaction: Transaction): UUID?

    fun findBy(id: UUID): Transaction?

    fun findTransactionBy(id: UUID): ResultRow?

    fun findAll(): List<Transaction>

    fun updateStatus(id: UUID, status: Int): ResultRow?

    fun findByBuyer(buyerId: UUID): List<Transaction>

    fun findBySeller(sellerId: UUID): List<TransactionWrapper>

}