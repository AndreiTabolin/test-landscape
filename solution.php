<?php

/**
 * Solution that calculates max water depth for a given landscape.
 *
 * @param array $A
 *   Landscape data. Keys (1..100000), Values (1..100000000).
 *
 * @return int
 *   Max depth value
 *
 * @throws \Exception
 */
function solution(array $A) {
  // Initial values.
  $result = [];
  $leftMax = 1;
  $rightMax = 1;
  $dataMaxCount = 100000;
  $dataMaxValue = 100000000;

  $count = count($A);
  ksort($A);

  // Validate data size.
  if (!$count || $count > $dataMaxCount) {
    throw new Exception("Wrong size of data. There should be 1..{$dataMaxCount} elements");
  }

  // Validate array keys.
  if (array_keys($A) !== range(0, $count - 1)) {
    throw new Exception('Array contains invalid key.');
  }

  // Starting indices.
  $left = 0;
  $right = $count - 1;

  while ($left <= $right) {
    $leftValue = $A[$left];
    $rightValue = $A[$right];
    $leftValueInvalid = !is_int($leftValue) || $leftValue < 1 || $leftValue > $dataMaxValue;
    $rightValueInvalid = !is_int($rightValue) || $rightValue < 1 || $rightValue > $rightValue;

    if ($leftValueInvalid || $rightValueInvalid) {
      throw new Exception("Invalid value detected. It should be integer and between 1..{$dataMaxValue} elements");
    }

    if ($leftValue < $rightValue) {
      // Update max in left.
      if ($leftValue > $leftMax) {
        $leftMax = $leftValue;
      }
      else {
        $result[] = $leftMax - $leftValue;
      }
      $left++;
    }
    else {
      // Update right maximum.
      if ($rightValue > $rightMax) {
        $rightMax = $rightValue;
      }
      else {
        $result[] = $rightMax - $rightValue;
      }
      $right--;
    }
  }

  return max($result);
}

/**
 * Dummy tests.
 */
function solutionDummyDataTest() {
  $data = [
    [1, 2, 3, 4, 5],
    [5, 4, 3, 2, 1],
    [-1, 3, 6],
    [1, 4],
    [0, 2, 5],
    [TRUE, 2, 5],
    ['stringKey' => 1, 2, 20],
    ['stringValue', 2, 20],
    [],
    [1, 3, 2, 1, 2, 1, 5, 3, 3, 4, 2], // From the description.
  ];

  foreach ($data as $landscape) {
    try {
      $result = solution($landscape);
      echo $result, '</br>';
    } catch (Exception $e) {
      echo 'Exception: ', $e->getMessage(), '</br>';
    }
  }
}
