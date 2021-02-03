package com.warungsoftware.domain.repository

import domain.model.Categories
import domain.model.Category
import ext.toCategoryModel
import org.jetbrains.exposed.sql.insert
import org.jetbrains.exposed.sql.select
import org.jetbrains.exposed.sql.selectAll
import org.jetbrains.exposed.sql.transactions.transaction
import org.jetbrains.exposed.sql.update
import java.util.*

class CategoryRepositoryImpl : CategoryRepository {
    override fun create(category: Category): UUID? {
        return transaction {
            Categories.insert { row ->
                row[name] = category.name
                row[description] = category.description ?: ""
                row[imageCoverUrl] = category.imageCoverUrl ?: ""
                row[imageUrl] = category.imageUrl ?: ""
            }.getOrNull(Categories.id)
        }
    }

    override fun findById(id: UUID): Category? {
        return transaction {
            Categories
                .select { Categories.id eq id }
                .map {
                    it.toCategoryModel()
                }
                .firstOrNull()
        }
    }

    override fun findBy(name: String): List<Category> {
        return transaction {
            Categories
                .select { Categories.name like "%$name%"  }
                .map { it.toCategoryModel() }
        }
    }

    override fun findAll(): List<Category> {
        return transaction {
            Categories
                .selectAll()
                .map {
                    it.toCategoryModel()
                }
        }
    }

    override fun delete(id: UUID): Int {
        return transaction {
            Categories.update({ Categories.id eq id }) {
                it[status] = false
            }
        }
    }

    override fun update(id: UUID, imageUrl: String, description: String, imageCoverUrl: String): Category? {
        return transaction {
            Categories.update({ Categories.id eq id }) {
                it[this.imageUrl] = imageUrl
                it[this.description] = description
                it[this.imageCoverUrl] = imageCoverUrl
            }

            findById(id)
        }
    }
}