<?php

require_once(xContext::$basepath.'/lib/protview/protview/geom/shape/complex/ComplexShape.php');
require_once(xContext::$basepath.'/lib/protview/protview/geom/shape/basic/Line.php');

class MembranePattern extends ComplexShape {

	//distributes all elements in steady way to all lines
	//number * amino acid size
	private $maxLineLength;
	private $length;
	private $membraneCoords = array("startX" => 0, "startY" => 0, "height" => 0, "width" => 0);
	

	public function __construct($offset, $startCoord = null) {
		parent::__construct($offset, $startCoord);
	}
	
	public function getMaxLineLength()
	{
		return $this->maxLineLength;
	}
	
	public function setMaxLineLength($maxLineLength)
	{
		$this->maxLineLength = $maxLineLength;
	}

	public function getLength()
	{
		return $this->length;
	}
	
	public function setLength($length)
	{
		$this->length = $length;
	}
	
	public function getMembraneCoords()
	{
		return $this->membraneCoords;
	}
	
	public function getCoord() {
		$coords = array();
		//distributes elements
		$values = array();
		$nb_values = 0;
		$nb = round($this->getLength() / $this->getMaxLineLength());
		for ($count = 1; $count < $this->getMaxLineLength(); $count++) {
				
			$nb_values += $nb;
			$values[] = $nb;
		}
		
		//exchanges the value in the middle and the last one
		$middleIndex = (int)($this->getMaxLineLength()/2);
		
		$tmp = $values[$middleIndex];
		
		$values[] = $tmp;
		
		$values[$middleIndex] = $this->getLength()-$nb_values;;
		
		
		$startCoord = parent::getStartCoord();
		$rotation = parent::getRotation();
		//initial x,y coordiante
		$startCoord['y'] += parent::getOffset() * $rotation['sens'];
		$startX = $startCoord['x'];
		$startY = $startCoord['y'];
		
		$lastCoord = $startCoord;
		
		$line = new Line(parent::getOffset(), $startCoord);
		
		for ($i = 0; $i < $this->getMaxLineLength(); $i++) {
			$currentLength = $values[$i];
				
			$line->setNbPoints($currentLength);
			$line->setRotation($rotation);
			$coord = $line->getCoord();		
				
			$coords = array_merge($coords, $coord);
		
			$lastCoord = $line->getLastCoord();
			if ($i + 1 < $this->getMaxLineLength())	{
				if ($i % 2 == 0) {
					$lastCoord['x'] = $coord[1]['x'];
					$lastCoord['y'] = $coord[1]['y'] + parent::getOffset() * $rotation['sens'];
				}
				else {
					$lastCoord['x'] = $startX;
					$lastCoord['y'] = $startY + parent::getOffset() * ($i+1) * $rotation['sens'];
				}
				
				$line = new Line(parent::getOffset(), $lastCoord);
			}
				
		}

		//calculates the membranes position and height
		
		if ($startX < $this->membraneCoords['startX'])
			$this->membraneCoords['startX'] = $startX;
		
		if ($startY < $this->membraneCoords['startY'])
			$this->membraneCoords['startY'] = $startY;
		
		if ($lastCoord['x'] - $startX > $this->membraneCoords['width'])
			$this->membraneCoords['width'] = $lastCoord['x'] - $startX;
		
		if ($lastCoord['y'] - $startY > $this->membraneCoords['height'])
			$this->membraneCoords['height'] = $lastCoord['y'] - $startY;
		
		parent::setLastCoord($lastCoord);
		return $coords;
	}

}

?>