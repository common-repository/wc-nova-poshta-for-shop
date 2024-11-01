<?php 

class NPFW_Parser{
	 /* ==========================================
        Parse JSON
    ========================================== */
    public function npfw_parseJSON($str) {
        $result = json_decode($str);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $result;
        }
        return $str;
    }
}