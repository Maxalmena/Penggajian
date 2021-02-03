package com.warungsoftware.domain.repository

import com.warungsoftware.domain.model.Helper
import com.warungsoftware.domain.model.Helpers
import ext.toHelperModel
import ext.toPaymentMethodModel
import org.jetbrains.exposed.sql.insert
import org.jetbrains.exposed.sql.select
import org.jetbrains.exposed.sql.selectAll
import org.jetbrains.exposed.sql.transactions.transaction
import org.jetbrains.exposed.sql.update
import java.util.*

class HelperRepositoryImpl : HelperRepository {
    override fun create(helper: Helper): Helper {
        return transaction {
            val id = Helpers.insert { row ->
                row[type] = helper.type
                row[value] = helper.value
            }.getOrNull(Helpers.id)

            findById(id!!)!!
        }
    }

    override fun findById(id: UUID): Helper? {
        return transaction {
            Helpers.select{Helpers.id eq id}
                .map {
                    it.toHelperModel()
                }
                .firstOrNull()
        }
    }

    override fun findAll(): List<Helper> {
        return transaction {
            Helpers.selectAll()
                .map {
                    it.toHelperModel()
                }
        }
    }

    override fun findByType(type: String): Helper? {
        return transaction {
            Helpers.select{Helpers.type eq type}
                .map {
                    it.toHelperModel()
                }
                .firstOrNull()
        }
    }

    override fun update(type: String, helper: Helper): Helper {
        return transaction {
            Helpers.update({ Helpers.type eq type }) {
                it[value] = helper.value
            }

            findByType(type)!!
        }
    }
}