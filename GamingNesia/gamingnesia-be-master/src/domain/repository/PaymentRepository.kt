package com.warungsoftware.domain.repository

import domain.model.Payment
import java.util.*

interface PaymentRepository {

    fun create(payment: Payment): UUID?

    fun findBy(id: UUID): Payment?

}