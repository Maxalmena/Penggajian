package com.warungsoftware.domain.repository

import com.warungsoftware.domain.model.PaymentMethod
import com.warungsoftware.domain.model.PaymentMethods
import ext.toPaymentMethodModel
import org.jetbrains.exposed.sql.insert
import org.jetbrains.exposed.sql.select
import org.jetbrains.exposed.sql.selectAll
import org.jetbrains.exposed.sql.transactions.transaction
import org.jetbrains.exposed.sql.update
import java.util.*

class PaymentMethodRepositoryImpl : PaymentMethodRepository {
    override fun create(paymentMethod: PaymentMethod): PaymentMethod? {
        return transaction {
            val id = PaymentMethods.insert { row ->
                row[accountName] = paymentMethod.accountName
                row[accountNumber] = paymentMethod.accountNumber
                row[name] = paymentMethod.name
            }.getOrNull(PaymentMethods.id)

            findBy(id!!)
        }
    }

    override fun findBy(id: UUID): PaymentMethod? {
        return transaction {
            PaymentMethods.select { PaymentMethods.id eq id }
                .map {
                    it.toPaymentMethodModel()
                }
                .firstOrNull()
        }
    }

    override fun findAll(): List<PaymentMethod> {
        return transaction {
            PaymentMethods
                .select{ PaymentMethods.status eq true }
                .map {
                    it.toPaymentMethodModel()
                }
        }
    }

    override fun delete(id: UUID): Int? {
        return transaction {
            PaymentMethods.update({ PaymentMethods.id eq id }) {
                it[status] = false
            }

        }
    }
}