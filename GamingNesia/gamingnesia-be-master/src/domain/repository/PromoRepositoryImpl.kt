package com.warungsoftware.domain.repository

import com.warungsoftware.ext.toUUID
import domain.model.Promos
import domain.model.Promo
import domain.model.PromoDto
import ext.toPromoModel
import org.jetbrains.exposed.sql.insert
import org.jetbrains.exposed.sql.select
import org.jetbrains.exposed.sql.selectAll
import org.jetbrains.exposed.sql.transactions.transaction
import org.jetbrains.exposed.sql.update
import java.util.*

class PromoRepositoryImpl : PromoRepository {
    override fun create(promo: Promo, productId: UUID): UUID? {
        return transaction {
            Promos.insert { row ->
                row[name] = promo.name
                row[description] = promo.description
                row[this.productId] = productId
                row[unit] = promo.unit
                row[values] = promo.values
                row[status] = promo.status ?: true
            }.getOrNull(Promos.id)
        }
    }

    override fun findById(id: UUID): Promo? {
        return transaction {
            Promos.select{ Promos.id eq id }
                .map {
                    it.toPromoModel()
                }
                .firstOrNull()
        }
    }

    override fun findAll(): List<Promo> {
        return transaction {
            Promos.selectAll()
                .map {
                    it.toPromoModel()
                }
        }
    }

    override fun delete(id: UUID): Int {
        return transaction {
            Promos.update({ Promos.id eq id }) {
                it[status] = false
            }
        }
    }

    override fun findByProduct(productId: UUID): Promo? {
        return transaction {
            Promos.select{ Promos.productId eq productId }
                .map {
                    it.toPromoModel()
                }
                .firstOrNull()
        }
    }

    override fun updatePromo(productId: UUID, promoDto: PromoDto?): Promo? {
        return transaction {
            Promos.update({ Promos.productId eq productId }) {
                it[status] = promoDto?.status!!
                it[values] = promoDto.values
                it[unit] = promoDto.unit
            }

            findByProduct(productId)
        }

    }
}