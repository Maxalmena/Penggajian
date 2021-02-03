package com.warungsoftware.domain.service

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.model.PaymentMethod
import com.warungsoftware.domain.repository.PaymentMethodRepository
import com.warungsoftware.ext.isUUIDValid
import com.warungsoftware.ext.toUUID

class PaymentMethodsService (private val paymentMethodRepository: PaymentMethodRepository) {

    fun getAll(): List<PaymentMethod> {
        return paymentMethodRepository.findAll()
    }

    fun create(paymentMethod: PaymentMethod): PaymentMethod? {
        return paymentMethodRepository.create(paymentMethod)
    }

    fun delete(id: String): Int? {
        require(id.isUUIDValid()) { throw InvalidRequestException("Id is not valid") }

        return paymentMethodRepository.delete(id.toUUID())
    }

}