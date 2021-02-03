package com.warungsoftware.domain.repository

import com.warungsoftware.ext.toUUID
import domain.model.Payment
import domain.model.Payments
import ext.toPaymentModel
import org.jetbrains.exposed.sql.insert
import org.jetbrains.exposed.sql.select
import org.jetbrains.exposed.sql.transactions.transaction
import java.util.*

class PaymentRepositoryImpl : PaymentRepository {
    override fun create(payment: Payment): UUID? {
        return transaction {
            Payments.insert { row ->
                row[method] = payment.method.toUUID()
                row[paymentAmount] = payment.paymentAmount
                row[paymentConfirmationPic] = payment.paymentConfirmationImage
                row[remarks] = payment.remarks
            }.getOrNull(Payments.id)
        }
    }

    override fun findBy(id: UUID): Payment? {
        return transaction {
            Payments.select { Payments.id eq id }
                .map {
                    it.toPaymentModel()
                }
                .firstOrNull()
        }
    }
}