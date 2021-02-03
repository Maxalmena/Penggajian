package com.warungsoftware.domain.model

import org.jetbrains.exposed.sql.Table
import java.util.*

data class Helper(
    val id: UUID ?= UUID.randomUUID(),
    val type: String,
    val value: String
)

object Helpers: Table() {
    val id = uuid("id").primaryKey().autoGenerate()
    val type = text("type")
    val value = text("value")
}