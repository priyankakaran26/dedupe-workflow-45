<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.5                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2014                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*/

/**
 * Class CRM_Core_HTMLInputCoder
 */
class CRM_Core_HTMLInputCoder {

  /**
   * @param string $fldName
   * @return bool TRUE if encoding should be skipped for this field
   */
  public static function isSkippedField($fldName) {
    return CRM_Utils_API_HTMLInputCoder::singleton()->isSkippedField($fldName);
  }

  /**
   * This function is going to filter the
   * submitted values across XSS vulnerability.
   *
   * @param array|string $values
   * @param bool $castToString If TRUE, all scalars will be filtered (and therefore cast to strings)
   *    If FALSE, then non-string values will be preserved
   */
  public static function encodeInput(&$values, $castToString = TRUE) {
    return CRM_Utils_API_HTMLInputCoder::singleton()->encodeInput($values, $castToString);
  }

}
