package com.warungsoftware.domain.service

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.repository.ProductRepository
import com.warungsoftware.domain.repository.PromoRepository
import com.warungsoftware.ext.*
import domain.model.Product
import domain.model.ProductDto
import domain.model.PromoDto
import java.util.*

class ProductService (
    private val productRepository: ProductRepository,
    private val promoRepository: PromoRepository
) {

    fun create(productDto: ProductDto) : ProductDto {
        productRepository.create(productDto.toProductModel()).let {
            promoRepository.create(productDto.promo!!.toPromoModel(), it!!).let { promoId ->
                promoRepository.findById(promoId!!).let { promo->
                    return productRepository.findById(it)!!.toPromoDto(promo)
                }
            }
        }
    }

    fun getAll(): List<ProductDto> {
        val list = mutableListOf<ProductDto>()
        productRepository.getAll().forEach { product ->
            promoRepository.findByProduct(product.id!!.toUUID()).let {
                list.add(product.toPromoDto(it))
            }
        }

        return list
    }

    fun getById(id: String) : ProductDto? {
        println("id = $id")
        require(id.isUUIDValid()) { throw InvalidRequestException("Id is not valid") }
        return productRepository.findById(id.toUUID()).apply {
            require(this != null) { throw NotFoundException("Product is not found") }
        }?.let { product ->
            promoRepository.findByProduct(product.id!!.toUUID()).let {
                product.toPromoDto(it)
            }
        }
    }

    fun findBy(name: String): List<ProductDto> {
        require(name.isNotEmpty()) { throw InvalidRequestException("name cannot be empty") }
        val list = mutableListOf<ProductDto>()
        productRepository.findBy(name).apply {
            require(this.count() != 0) {
                return emptyList()
            }
        }.forEach { product ->
            promoRepository.findByProduct(product.id!!.toUUID()).let {
                list.add(product.toPromoDto(it))
            }
        }
        return list
    }

    fun delete(id: String): Int {
        require(id.isUUIDValid()) { throw InvalidRequestException("Id is not valid") }
        return productRepository.delete(id.toUUID()).apply {
            require(this != 0) { throw NotFoundException("Product is not found") }
        }
    }

    fun findBySeller(sellerId: String): List<ProductDto> {
        require(sellerId.isNotEmpty()) { throw InvalidRequestException("name cannot be empty") }
        val list = mutableListOf<ProductDto>()
        productRepository.findBySeller(sellerId.toUUID()).apply {
            require(this.count() != 0) {
                return emptyList()
            }
        }.forEach { product ->
            promoRepository.findByProduct(product.id!!.toUUID()).let {
                list.add(product.toPromoDto(it))
            }
        }
        return list
    }

    fun findByCategory(categoryId: String): List<ProductDto> {
        require(categoryId.isNotEmpty()) { throw InvalidRequestException("name cannot be empty") }
        val list = mutableListOf<ProductDto>()
        productRepository.findByCategory(categoryId.toUUID()).apply {
            require(this.count() != 0) {
                return emptyList()
            }
        }.forEach { product ->
            promoRepository.findByProduct(product.id!!.toUUID()).let {
                list.add(product.toPromoDto(it))
            }
        }
        return list
    }

    fun updateProduct(productId: String, productDto: ProductDto): ProductDto? {
        require(productId.isNotEmpty()) { throw InvalidRequestException("id cannot be empty") }
        productRepository.findById(productId.toUUID()).let {
            require(it != null) { throw InvalidRequestException("id cannot be empty") }
            val promo = promoRepository.updatePromo(it.id!!.toUUID(), productDto.promo)
            return productRepository.updateProduct(it.id.toUUID(), productDto.toProductModel())?.toPromoDto(promo)
        }
    }

}