package ext

import org.jetbrains.exposed.sql.Column
import org.jetbrains.exposed.sql.ColumnType
import org.jetbrains.exposed.sql.Table
import org.postgresql.jdbc.PgArray
import java.sql.PreparedStatement

fun Table.stringArray(name: String): Column<List<String>> =
    registerColumn(name, StringArrayColumnType())

internal class StringArrayColumnType : ColumnType() {
    override fun sqlType() = "varchar[]"
    override fun valueFromDB(value: Any): List<String> = when (value) {
        is Iterable<*> -> value.map { it.toString() }
        is PgArray -> {
            val array = value.array
            if (array is Array<*>) {
                array.map {
                    when (it) {
                        is String -> it
                        null -> error("Unexpected value of type String but value is $it")
                        else -> error("Unexpected value of type String: $it of ${it::class.qualifiedName}")
                    }
                }
            } else {
                throw Exception("Values returned from database if not of type kotlin Array<*>")
            }
        }
        else -> throw Exception("Values returned from database if not of type PgArray")
    }

    override fun valueToString(value: Any?): String = when (value) {
        null -> {
            if (!nullable) error("NULL in non-nullable column")
            "NULL"
        }

        is Iterable<*> -> {
            "'{${value.joinToString()}}'"
        }

        else -> {
            nonNullValueToString(value)
        }
    }

    override fun setParameter(stmt: PreparedStatement, index: Int, value: Any?) {
        if (value is List<*>) {
            stmt.setArray(index, stmt.connection.createArrayOf("varchar", value.toTypedArray()))
        } else {
            super.setParameter(stmt, index, value)
        }
    }
}