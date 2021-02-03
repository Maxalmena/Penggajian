package com.warungsoftware.domain.repository

import domain.model.Promo
import domain.model.PromoDto
import java.util.*

interface PromoRepository {

    fun create(promo: Promo, productId: UUID): UUID?

    fun findById(id: UUID): Promo?

    fun findAll(): List<Promo>

    fun delete(id: UUID): Int

    fun findByProduct(productId: UUID): Promo?

    fun updatePromo(productId: UUID, promoDto: PromoDto?): Promo?

}