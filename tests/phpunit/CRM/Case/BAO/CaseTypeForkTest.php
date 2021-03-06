<?php

require_once 'CiviTest/CiviCaseTestCase.php';

/**
 * Case Types support an optional forking mechanism wherein the local admin
 * creates a custom DB-based definition that deviates from the file-based definition.
 */
class CRM_Case_BAO_CaseTypeForkTest extends CiviCaseTestCase {
  public function setUp() {
    parent::setUp();
    CRM_Core_ManagedEntities::singleton(TRUE)->reconcile();
  }

  function tearDown() {
    parent::tearDown();
    CRM_Core_ManagedEntities::singleton(TRUE)->reconcile();
  }


  /**
   * Edit the definition of ForkableCaseType
   */
  function testForkable() {
    $caseTypeId = CRM_Core_DAO::getFieldValue('CRM_Case_DAO_CaseType', 'ForkableCaseType', 'id', 'name');
    $this->assertTrue(is_numeric($caseTypeId) && $caseTypeId > 0);

    $this->assertDBNull('CRM_Case_BAO_CaseType', $caseTypeId, 'definition', 'id', "Should not have DB-based definition");
    $this->assertTrue(CRM_Case_BAO_CaseType::isForkable($caseTypeId));
    $this->assertFalse(CRM_Case_BAO_CaseType::isForked($caseTypeId));

    $this->callAPISuccess('CaseType', 'create', array(
      'id' => $caseTypeId,
      'definition' => array(
        'activityTypes' => array(
          array('name' => 'First act'),
          array('name' => 'Second act'),
        ),
      )
    ));

    $this->assertTrue(CRM_Case_BAO_CaseType::isForkable($caseTypeId));
    $this->assertTrue(CRM_Case_BAO_CaseType::isForked($caseTypeId));
    $this->assertDBNotNull('CRM_Case_BAO_CaseType', $caseTypeId, 'definition', 'id', "Should not have DB-based definition");

    $this->callAPISuccess('CaseType', 'create', array(
      'id' => $caseTypeId,
      'definition' => 'null',
    ));

    $this->assertDBNull('CRM_Case_BAO_CaseType', $caseTypeId, 'definition', 'id', "Should not have DB-based definition");
    $this->assertTrue(CRM_Case_BAO_CaseType::isForkable($caseTypeId));
    $this->assertFalse(CRM_Case_BAO_CaseType::isForked($caseTypeId));
  }

  /**
   * Attempt to edit the definition of UnforkableCaseType. This fails.
   */
  function testUnforkable() {
    $caseTypeId = CRM_Core_DAO::getFieldValue('CRM_Case_DAO_CaseType', 'UnforkableCaseType', 'id', 'name');
    $this->assertTrue(is_numeric($caseTypeId) && $caseTypeId > 0);
    $this->assertDBNull('CRM_Case_BAO_CaseType', $caseTypeId, 'definition', 'id', "Should not have DB-based definition");

    $this->assertFalse(CRM_Case_BAO_CaseType::isForkable($caseTypeId));
    $this->assertFalse(CRM_Case_BAO_CaseType::isForked($caseTypeId));

    $this->callAPISuccess('CaseType', 'create', array(
      'id' => $caseTypeId,
      'definition' => array(
        'activityTypes' => array(
          array('name' => 'First act'),
          array('name' => 'Second act'),
        ),
      )
    ));

    $this->assertFalse(CRM_Case_BAO_CaseType::isForkable($caseTypeId));
    $this->assertFalse(CRM_Case_BAO_CaseType::isForked($caseTypeId));
    $this->assertDBNull('CRM_Case_BAO_CaseType', $caseTypeId, 'definition', 'id', "Should not have DB-based definition");
  }

  /**
   * @param $caseTypes
   * @see \CRM_Utils_Hook::caseTypes
   */
  function hook_caseTypes(&$caseTypes) {
    $caseTypes['ForkableCaseType'] = array(
      'module' => 'civicrm',
      'name' => 'ForkableCaseType',
      'file' => __DIR__ . '/ForkableCaseType.xml',
    );
    $caseTypes['UnforkableCaseType'] = array(
      'module' => 'civicrm',
      'name' => 'UnforkableCaseType',
      'file' => __DIR__ . '/UnforkableCaseType.xml',
    );
  }

}