package com.warungsoftware.config

import com.warungsoftware.domain.model.Helpers
import domain.model.*
import domain.model.Products
import org.jetbrains.exposed.sql.Database
import org.jetbrains.exposed.sql.transactions.transaction
import org.jetbrains.exposed.sql.SchemaUtils.create
import org.jetbrains.exposed.sql.transactions.experimental.newSuspendedTransaction

object DbConfig {
    fun setup (username: String, password: String) {
        Database.connect(
            url = System.getenv("JDBC_DATABASE_URL"),
            driver = "org.postgresql.Driver",
            user = username,
            password = password
        )
    }

    // only run once when need to create new table
    fun createTable() {
        transaction {
            create(Categories)
            create(Roles)
            create(Users)
            create(Products)
            create(Promos)
            create(Payments)
            create(Transactions)
            create(TransactionDetails)
            create(Helpers)
        }
    }

    suspend fun <T> dbQuery(
        block: suspend () -> T): T =
        newSuspendedTransaction { block() }
}