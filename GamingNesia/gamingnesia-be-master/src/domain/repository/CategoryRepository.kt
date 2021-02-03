package com.warungsoftware.domain.repository

import domain.model.Category
import java.util.*

interface CategoryRepository {

    fun create(category: Category): UUID?

    fun findById(id: UUID): Category?

    fun findBy(name: String): List<Category>

    fun findAll(): List<Category>

    fun delete(id: UUID): Int

    fun update(id: UUID, imageUrl: String, description: String, imageCoverUrl: String): Category?

}