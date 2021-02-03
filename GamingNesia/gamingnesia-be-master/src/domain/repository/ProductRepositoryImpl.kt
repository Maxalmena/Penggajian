package com.warungsoftware.domain.repository

import com.warungsoftware.ext.toUUID
import domain.model.Product
import domain.model.Products
import ext.toProductModel
import org.jetbrains.exposed.sql.*
import org.jetbrains.exposed.sql.transactions.transaction
import java.util.*

class ProductRepositoryImpl : ProductRepository {

    override fun getAll(): List<Product> {
        return transaction {
            Products.selectAll().map {
                it.toProductModel()
            }
        }
    }

    override fun create(product: Product): UUID? {
        return transaction {
            Products.insert { row ->
                row[name] = product.name
                row[imageUrl] = product.imageUrl
                row[purchasesPrice] = product.purchasesPrices
                row[sellingPrice] = product.sellingPrice
                row[sku] = product.sku
                row[stock] = product.stock
                row[categoryId] = product.categoryId.toUUID()
                row[userId] = product.userId?.toUUID()!!
                row[status] = product.status ?: true
            }.getOrNull(Products.id)
        }
    }

    override fun findById(id: UUID): Product? {
        return transaction {
            Products.select { Products.id eq id }
                .map {
                    it.toProductModel()
                }.firstOrNull()
        }
    }

    override fun findBy(name: String): List<Product> {
        return transaction {
            Products
                .select { Products.name like "%$name%" }
                .map { it.toProductModel() }
        }
    }

    override fun delete(id: UUID): Int {
        return transaction {
            Products.update({ Products.id eq id }) {
                it[status] = false
            }
        }
    }

    override fun findBySeller(sellerId: UUID): List<Product> {
        return transaction {
            Products
                .select { Products.userId eq sellerId }
                .map { it.toProductModel() }
        }
    }

    override fun findByCategory(categoryId: UUID): List<Product> {
        return transaction {
            Products
                .select { Products.categoryId eq categoryId }
                .map { it.toProductModel() }
        }
    }

    override fun updateProduct(productId: UUID, product: Product): Product? {
        return transaction {
            Products.update({Products.id eq productId}) { row ->
                row[name] = product.name
                row[imageUrl] = product.imageUrl
                row[purchasesPrice] = product.purchasesPrices
                row[sellingPrice] = product.sellingPrice
                row[sku] = product.sku
                row[stock] = product.stock
                row[categoryId] = product.categoryId.toUUID()
            }

            findById(productId)
        }
    }

}