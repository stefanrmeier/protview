<?php

require_once('CoordinatesCalculator.php');

class ProteinCalc {
	
	private $params = array(
			"maxHeigh" => 1000, //max graphic height in px
			"maxWidth" => 1000, //max graphic width in px
			"minDmainSpace" => 20 //min space beetwen ext/int domain in px
			);
	private $protein;
	private $startCoord;
	private $aaSize;
	private $coordinatesCalculator;
	
	private $aaCoords = array();
	private $membraneCoords = array("startX" => 0, "startY" => 0, "height" => 0, "width" => 0);
	
	public function __construct($protein, $startCoord, $aaSize) {
		$this->protein = $protein;
		$this->startCoord = $startCoord;
		$this->aaSize = $aaSize;
		$this->coordinatesCalculator = new CoordinatesCalculator($aaSize, $this->startCoord);
		$this->calculateCoordinates();
	}
	
	private function calculateCoordinates() {
		$coords = array();
		$pos = 1;
		foreach ($this->protein->getSubunits() as $subunit) {
			foreach ($subunit->getPeptides() as $peptide) {
				
				$countAminoAcids = $peptide->countBiggestMembrane();			
				foreach ($peptide->getDomains() as $domain) {
					$type = $domain->getType();
						
					if ($type == 'intra')
						$pos = -1;
					else if ($type == 'extra')
						$pos = 1;
					if ($type == 'trans')
						$coords = array_merge($coords, $this->getMembranePart($domain, $countAminoAcids, $pos));
					else {
						$coords = array_merge($coords, $this->getExternalPart($domain, $pos));
					}
				}
			}
		}
	
		$this->AAcoords = $coords;
	}
	
	/**
	 * Calculates coordinates of external part of the membraine
	 * @param unknown_type $domain
	 * @param unknown_type $pos
	 */
	private function getExternalPart($domain, $pos) {
		$coords = array();
		
		$aminoAcids = $domain->getAminoAcids();
		
		$length = count($aminoAcids);
		
		$even = false;
		
		$params = array(
				"maxHeigh" => 1000, //max graphic height in px
				"maxWidth" => 1000, //max graphic width in px
				"minDomainSpace" => 150 //min space beetwen ext/int domain in px
		);
		

		$middle = 0;
		
		if ($length % 2 == 0)
			$even = true;
		
		if ($length <= 20) {
			if ($even)
				$middle = 8;
			else 
				$middle = 7;
		}
		else {
			if ($even)
				$middle = 4;
			else
				$middle = 3;
			
		}
		
		//min space between domain, needs to be implemented and should not be hardcoded
		$middle = ceil($params['minDomainSpace']/$this->aaSize);
		
		$height = ($length - $middle)/2;		
		
		/*
		 * Calculating positions
		 */
		//left
		$this->coordinatesCalculator->setSequenceLength($height);
		$lastCoord = $this->coordinatesCalculator->getLastCoord();	
		$lastCoord['y'] -= $this->aaSize * $pos;
		$this->coordinatesCalculator->setStartCoord($lastCoord);
		$coord = $this->coordinatesCalculator->calculateLine($pos);
		$coords = array_merge($coords, $coord);

		//middle
		$this->coordinatesCalculator->setSequenceLength($middle);
		$lastCoord = $this->coordinatesCalculator->getLastCoord();			
		$lastCoord['y'] -= $this->aaSize * $pos;	
		$this->coordinatesCalculator->setStartCoord($lastCoord);
		$coord = $this->coordinatesCalculator->calculateCercle($pos);
		$coords = array_merge($coords, $coord);
	
		//right
		$this->coordinatesCalculator->setSequenceLength($height);
		$lastCoord = $this->coordinatesCalculator->getLastCoord();	
		$lastCoord['y'] += $this->aaSize * $pos;
		$this->coordinatesCalculator->setStartCoord($lastCoord);
		$coord = $this->coordinatesCalculator->calculateLine(-1 * $pos);
		$coords = array_merge($coords, $coord);
		return $coords;
	}
	
	private function getMembranePart($domain, $countAminoAcids, $pos) {
		$coords = array ();
		
		$aminoAcids = $domain->getAminoAcids();
		
		$length = count($aminoAcids);

		//Rotation angle
		$angle = 165;
		
		if ($pos == 1) {
			$angle = 345;
		}
		
		//distributes all elements in steady way to all lines
		$maxLines = 6; //number * amino acid size
		
		//distributes elements 
		$values = array();
		$nb = round($length / $maxLines);
		for ($count = 1; $count < $maxLines; $count++) {
			
			$nb_values += $nb;
			$values[] = $nb;
		}
		
		//exchanges the value in the middle and the last one
		$middleIndex = (int)($maxLines/2);
		
		$tmp = $values[$middleIndex];
		
		$values[] = $tmp;
		
		$values[$middleIndex] = $length-$nb_values;;
		
		
		$lastCoord = $this->coordinatesCalculator->getLastCoord();
		//initial x,y coordiante
		$lastCoord['y'] += $this->aaSize * $pos;
		$startX = $lastCoord['x'];
		$startY = $lastCoord['y'];
		
		$this->coordinatesCalculator->setStartCoord($lastCoord);
		
		
		for ($i = 0; $i < $maxLines; $i++) {
			$currentLength = $values[$i];
			
			$this->coordinatesCalculator->setSequenceLength($currentLength);

			$coord = $this->coordinatesCalculator->calculateLine(1, $angle);
			
			
			$coords = array_merge($coords, $coord);

			$lastCoord = $this->coordinatesCalculator->getLastCoord();
			
			if ($i % 2 == 0) {
				$lastCoord['x'] = $coord[1]['x'];
				$lastCoord['y'] = $coord[1]['y'] + $this->aaSize * $pos;
			}
			else {
				$lastCoord['x'] = $startX;
				$lastCoord['y'] = $startY + $this->aaSize * ($i+1) * $pos;
			}
			$this->coordinatesCalculator->setStartCoord($lastCoord);
			
		}
		
		//calculates the membranes position and height
		$lastCoord = $this->coordinatesCalculator->getLastCoord();
		
		if ($startX < $this->membraneCoords['startX'])
			$this->membraneCoords['startX'] = $startX;
		
		if ($startY < $this->membraneCoords['startY'])
			$this->membraneCoords['startY'] = $startY;
		
		if ($lastCoord['x'] - $startX > $this->membraneCoords['width'])
			$this->membraneCoords['width'] = $lastCoord['x'] - $startX;
		
		if ($lastCoord['y'] - $startY > $this->membraneCoords['height'])
			$this->membraneCoords['height'] = $lastCoord['y'] - $startY;
		
		return $coords;
	}
	
	public function getAACoordinates() {
		return $this->AAcoords;
	}
	
	public function getMembraneCoordinates() {
		$this->membraneCoords['startX'] -= $this->aaSize/2;
		$this->membraneCoords['startY'] += $this->aaSize/2;
		
		
		return $this->membraneCoords;
	}
}

?>