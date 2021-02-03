package com.warungsoftware.domain.service

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.repository.CategoryRepository
import com.warungsoftware.ext.isUUIDValid
import com.warungsoftware.ext.toCategoryModel
import com.warungsoftware.ext.toUUID
import domain.model.Category
import domain.model.CategoryDto

class CategoryService (private val categoryRepository: CategoryRepository) {

    fun create(categoryDto: CategoryDto): Category {
        categoryRepository.create(categoryDto.toCategoryModel()).apply {
            return categoryRepository.findById(this!!)!!
        }
    }

    fun getById(id: String): Category? {
        require(id.isUUIDValid()) { throw InvalidRequestException("Id is not valid") }
        return categoryRepository.findById(id.toUUID()).apply {
            require(this != null) { throw NotFoundException("Category is not found") }
        }
    }

    fun getBy(name: String): List<Category> {
       require(name.isNotEmpty()) { throw InvalidRequestException("Name is empty") }
        return categoryRepository.findBy(name).apply {
            require(this.count() != 0) { throw NotFoundException("No category found") }
        }
    }

    fun getAll(): List<Category> = categoryRepository.findAll()

    fun delete(id: String): Int {
        require(id.isUUIDValid()) { throw InvalidRequestException("Id is not valid") }
        return categoryRepository.delete(id.toUUID()).apply {
            require(this != 0) { throw NotFoundException("Id is not found") }
        }
    }

    fun update(id: String, categoryDto: CategoryDto): Category? {
        require(id.isUUIDValid()) { throw InvalidRequestException("Id is not valid") }
        require(categoryDto.imageUrl.isNotEmpty() && categoryDto.description.isNotEmpty() && categoryDto.imageCoverUrl.isNotEmpty()) { throw InvalidRequestException("Description, ImageCoverUrl and ImageUrl cannot be empty") }
        return categoryRepository.update(id.toUUID(), categoryDto.imageUrl, categoryDto.description, categoryDto.imageCoverUrl)
    }

}