package domain.model

import org.jetbrains.exposed.sql.Table

data class Role(
    val id: String?,
    val name: String
)

object Roles: Table() {
    val id = uuid("id").primaryKey().autoGenerate()
    val name = varchar("name", 20)
}