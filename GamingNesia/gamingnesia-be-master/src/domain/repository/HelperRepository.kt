package com.warungsoftware.domain.repository

import com.warungsoftware.domain.model.Helper
import java.util.*

interface HelperRepository {

    fun create(helper: Helper): Helper

    fun findAll(): List<Helper>

    fun findById(id: UUID): Helper?

    fun findByType(type: String): Helper?

    fun update(type: String, helper: Helper): Helper

}