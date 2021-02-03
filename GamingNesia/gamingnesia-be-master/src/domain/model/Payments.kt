package domain.model

import com.warungsoftware.domain.model.PaymentMethods
import org.jetbrains.exposed.sql.Table

data class Payment(
    val id: String? = "",
    val method: String,
    val remarks: String = "",
    val paymentConfirmationImage: String,
    val paymentAmount: Float
)

object Payments: Table() {
    val id = uuid("id").autoGenerate().primaryKey()
    val method = (uuid("method") references PaymentMethods.id)
    val remarks = varchar("remarks", 255)
    val paymentConfirmationPic= varchar("payment_confirmation_pic", 255)
    val paymentAmount = float("payment_amount")
}