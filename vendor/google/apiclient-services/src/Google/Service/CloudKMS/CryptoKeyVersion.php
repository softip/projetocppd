<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_CloudKMS_CryptoKeyVersion extends Google_Model
{
  public $algorithm;
  protected $attestationType = 'Google_Service_CloudKMS_KeyOperationAttestation';
  protected $attestationDataType = '';
  public $createTime;
  public $destroyEventTime;
  public $destroyTime;
  protected $externalProtectionLevelOptionsType = 'Google_Service_CloudKMS_ExternalProtectionLevelOptions';
  protected $externalProtectionLevelOptionsDataType = '';
  public $generateTime;
  public $importFailureReason;
  public $importJob;
  public $importTime;
  public $name;
  public $protectionLevel;
  public $state;

  public function setAlgorithm($algorithm)
  {
    $this->algorithm = $algorithm;
  }
  public function getAlgorithm()
  {
    return $this->algorithm;
  }
  /**
   * @param Google_Service_CloudKMS_KeyOperationAttestation
   */
  public function setAttestation(Google_Service_CloudKMS_KeyOperationAttestation $attestation)
  {
    $this->attestation = $attestation;
  }
  /**
   * @return Google_Service_CloudKMS_KeyOperationAttestation
   */
  public function getAttestation()
  {
    return $this->attestation;
  }
  public function setCreateTime($createTime)
  {
    $this->createTime = $createTime;
  }
  public function getCreateTime()
  {
    return $this->createTime;
  }
  public function setDestroyEventTime($destroyEventTime)
  {
    $this->destroyEventTime = $destroyEventTime;
  }
  public function getDestroyEventTime()
  {
    return $this->destroyEventTime;
  }
  public function setDestroyTime($destroyTime)
  {
    $this->destroyTime = $destroyTime;
  }
  public function getDestroyTime()
  {
    return $this->destroyTime;
  }
  /**
   * @param Google_Service_CloudKMS_ExternalProtectionLevelOptions
   */
  public function setExternalProtectionLevelOptions(Google_Service_CloudKMS_ExternalProtectionLevelOptions $externalProtectionLevelOptions)
  {
    $this->externalProtectionLevelOptions = $externalProtectionLevelOptions;
  }
  /**
   * @return Google_Service_CloudKMS_ExternalProtectionLevelOptions
   */
  public function getExternalProtectionLevelOptions()
  {
    return $this->externalProtectionLevelOptions;
  }
  public function setGenerateTime($generateTime)
  {
    $this->generateTime = $generateTime;
  }
  public function getGenerateTime()
  {
    return $this->generateTime;
  }
  public function setImportFailureReason($importFailureReason)
  {
    $this->importFailureReason = $importFailureReason;
  }
  public function getImportFailureReason()
  {
    return $this->importFailureReason;
  }
  public function setImportJob($importJob)
  {
    $this->importJob = $importJob;
  }
  public function getImportJob()
  {
    return $this->importJob;
  }
  public function setImportTime($importTime)
  {
    $this->importTime = $importTime;
  }
  public function getImportTime()
  {
    return $this->importTime;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setProtectionLevel($protectionLevel)
  {
    $this->protectionLevel = $protectionLevel;
  }
  public function getProtectionLevel()
  {
    return $this->protectionLevel;
  }
  public function setState($state)
  {
    $this->state = $state;
  }
  public function getState()
  {
    return $this->state;
  }
}
