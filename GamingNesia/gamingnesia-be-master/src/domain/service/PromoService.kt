package com.warungsoftware.domain.service

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.repository.PromoRepository
import com.warungsoftware.ext.isUUIDValid
import com.warungsoftware.ext.toPromoModel
import com.warungsoftware.ext.toUUID
import domain.model.Promo
import domain.model.PromoDto

class PromoService (private val promoRepository: PromoRepository) {

    fun configPromo(promoDto: PromoDto): Promo {
        promoRepository.create(promoDto.toPromoModel(), promoDto.productId!!.toUUID()).let {
            return promoRepository.findById(it!!)!!
        }
    }

    fun getAll(): List<Promo> = promoRepository.findAll()

    fun getById(id: String): Promo? {
        require(id.isUUIDValid()) { throw InvalidRequestException("Id is not valid") }
        return promoRepository.findById(id.toUUID()).apply {
            require(this != null) { throw NotFoundException("Promo is not found") }
        }
    }

    fun delete(id: String): Int {
        require(id.isUUIDValid()) { throw InvalidRequestException("Id is not valid") }
        return promoRepository.delete(id.toUUID()).apply {
            require(this != 0) { throw NotFoundException("Promo is not found") }
        }
    }

}