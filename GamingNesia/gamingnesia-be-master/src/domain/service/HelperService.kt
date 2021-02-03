package com.warungsoftware.domain.service

import com.warungsoftware.domain.model.Helper
import com.warungsoftware.domain.repository.HelperRepository

class HelperService (private val helperRepository: HelperRepository) {

    fun create(helper: Helper): Helper {
        return helperRepository.create(helper)
    }

    fun findAll(): List<Helper> {
        return helperRepository.findAll()
    }

    fun findByType(type: String): Helper? {
        return helperRepository.findByType(type)
    }

    fun update(type: String, helper: Helper): Helper? {
        return helperRepository.update(type, helper)
    }

}