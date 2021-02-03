package com.warungsoftware.domain.repository

import domain.model.Product
import org.jetbrains.exposed.sql.ResultRow
import java.util.*

interface ProductRepository {

    fun getAll() : List<Product>

    fun create(product: Product) : UUID?

    fun findById(id: UUID): Product?

    fun findBy(name: String): List<Product>

    fun delete(id: UUID): Int

    fun findBySeller(sellerId: UUID): List<Product>

    fun findByCategory(categoryId: UUID): List<Product>

    fun updateProduct(productId: UUID, product: Product): Product?

}