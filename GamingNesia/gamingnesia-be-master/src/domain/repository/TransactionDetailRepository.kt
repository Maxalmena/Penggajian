package com.warungsoftware.domain.repository

import domain.model.TransactionDetail
import domain.model.TransactionDetailWrapper
import java.util.*

interface TransactionDetailRepository {

    fun batchCreate(transactionDetail: List<TransactionDetail>): List<TransactionDetail>

    fun findByTransaction(transactionId: UUID): List<TransactionDetailWrapper>

    fun findBySellerId(transactionId: UUID, sellerId: UUID): List<TransactionDetailWrapper>

}