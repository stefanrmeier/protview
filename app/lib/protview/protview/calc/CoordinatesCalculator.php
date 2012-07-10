<?php

require_once('CalcHelper.php');

class CoordinatesCalculator {
	private $scatterSize;
	private $sequenceLength;
	private $startCoord;
	private $endCoord;

	public function __construct($scatterSize, $startCoord = null) {
		$this->scatterSize = $scatterSize;

		if ($startCoord == null)
			$this->startCoord = array("x" => 0, "y" => 0);
		else
			$this->startCoord = $startCoord;
	}

	public function setScatterSize($scatterSizer) {
		$this->scatterSize = $scatterSize;
	}

	public function setSequenceLength($sequenceLength) {
		$this->sequenceLength = $sequenceLength;
	}

	public function setStartCoord($startCoord) {
		$this->startCoord = $startCoord;
	}

	public function getEndCoord() {
		return $this->endCoord;
	}

	/**
	 * Draws an arc in the specifiad rotation direction
	 * 
	 * Thanks to http://php.net/manual/ro/function.atan2.php 
	 * (comment Monte Shaffer 08-Jun-2007 11:35)
	 * 
	 * @param int $rotationSense (1 = bottom->up; -1 = top->down)
	 * @param int $degree (360° = cercle)
	 * 
	 * @return array (coordinates of each point on the perimeter)
	 */
	public function calculateArc($rotationSens = 1, $degree = 180) {
		$coord = array();

		/* calculates the cercle's radius
		 * 
		 * r = perimeter / pi
		 * 
		 * perimeter = scatterSize * sequenceLength
		 */
		$r = $this->scatterSize * $this->sequenceLength / M_PI;

		/*
		 * calculates spaces between each point
		 * 
		 * degrees / number of elements
		 */
		$offset = $degree/$this->sequenceLength;

		for ($angle = $degree; $angle >= 0; $angle -= $offset)	 {
			$nx = CalcHelper::getX($r, $rotationSens*$angle);
			$ny = CalcHelper::getY($r, $rotationSens*$angle);
				
			$x = $this->startCoord['x'] + $nx + $r;
			$y = $this->startCoord['y'] - $ny;

			$coord[] = array("x" => $x, "y" => $y);
		}
		$this->endCoord = end($coord);

		return $coord;
	}
	
	/**
	 * Calculates Line coordinates in fonction of indicated rotation angle
	 * 
	 * @param int $rotationSense (1 = bottom->up; -1 = top->down)
	 * @param int $angle (rotation angle, default 90° = vertical)
	 * @return array $coord (coordinates of each point)
	 */
	public function calculateLine($rotationSens = 1, $angle = 90) {
		$coord = array();
		
		$x = $this->startCoord['x'];
		$y = $this->startCoord['y'];

		$r = $this->scatterSize;
		
		for ($nb = 1; $nb <= $this->sequenceLength; $nb++) {
				$nx = CalcHelper::getX($r, $rotationSens*$angle);
				$ny = CalcHelper::getY($r, $rotationSens*$angle);
				
				$x -= $nx;
				$y -= $ny;

			$coord[] = array("x" => $x, "y" => $y);
		}

		$this->endCoord = end($coord);
		return $coord;
	}
}

?>