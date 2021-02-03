package com.warungsoftware.domain.model

import org.jetbrains.exposed.sql.Table

data class PaymentMethod(
    val id: String,
    val name: String,
    val accountNumber: String,
    val accountName: String,
    val status: Boolean = true
)

object PaymentMethods: Table() {
    val id = uuid("id").primaryKey().autoGenerate()
    val name = varchar("name", 100)
    val accountNumber = varchar("account_number", 100)
    val accountName = varchar("account_name", 100)
    val status = bool("status").default(true)
}