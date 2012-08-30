<?php

class SVGGraphics {
	
	public function drawAminoAcid($x, $y, $size, $label, $pos) {
		return "<g id=\"aa-{$pos}\" class=\"aa\" transform=\"translate({$x},{$y})\">
		<circle r=\"". ($size/2) . "\"/>
		<text x=\"-4\" y=\"0\">{$label}</text>
		<text class=\"seq_num\" x=\"-4\" y=\"6\">{$pos}</text>
		</g>";
	}
	
	public function drawMembrane($minX, $maxX, $minY, $maxY) {
		$membrane = "";
		$membrane .= "<line x1=\"$minX\" x2=\"$maxX\" y1=\"$minY\" y2=\"$minY\" style=\"fill:none;stroke:#d83200;stroke-width:2px;\"/>";
		$membrane .= "<line x1=\"$minX\" x2=\"$maxX\" y1=\"". (($maxY+$minY)/2) . "\" y2=\"". (($maxY+$minY)/2) ."\" style=\"fill:none;stroke:#fab998;stroke-width:". ($maxY-$minY) . "px;\"/>";
		$membrane .= "<line x1=\"$minX\" x2=\"$maxX\" y1=\"$maxY\" y2=\"$maxY\" style=\"fill:none;stroke:#d83200;stroke-width:1px;\"/>";
		return $membrane;
	}
}

?>