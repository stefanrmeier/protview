<?php

class StructureStartView extends xView {
    function init() {
        $this->meta = xUtil::array_merge($this->meta, array(
            'js' => array(
            	xUtil::url('a/js/protview/structure/controller/MainController.js'),
            	xUtil::url('a/js/protview/structure/model/Protein.js'),
            	xUtil::url('a/js/protview/structure/model/Peptide.js'),
            	xUtil::url('a/js/protview/structure/controller/ProteinController.js'),
            	xUtil::url('a/js/protview/structure/controller/NewProteinController.js'),
            	xUtil::url('a/js/protview/structure/controller/PeptideController.js'),
            	xUtil::url('a/js/protview/structure/view/NewProteinView.js'),
            	xUtil::url('a/js/protview/structure/view/ProteinView.js'),
            	xUtil::url('a/js/protview/structure/view/PeptideView.js'),
            )
        ));
    }
}