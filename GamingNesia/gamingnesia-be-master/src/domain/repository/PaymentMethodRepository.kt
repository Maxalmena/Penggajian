package com.warungsoftware.domain.repository

import com.warungsoftware.domain.model.PaymentMethod
import java.util.*

interface PaymentMethodRepository {

    fun create(paymentMethod: PaymentMethod): PaymentMethod?

    fun findBy(id: UUID): PaymentMethod?

    fun findAll(): List<PaymentMethod>

    fun delete(id: UUID): Int?

}