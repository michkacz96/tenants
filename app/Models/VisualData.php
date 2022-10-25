<?php

namespace App\Models;

class VisualData
{
    private $type;
    private $data = array(
        'labels' => array(),
        'datasets' => array(
            'label' => null,
            'data' => array()
            )
    );
    private $style = "backgroundColor:['rgba(255, 99, 132, 0.6)','rgba(54, 162, 235, 0.6)','rgba(255, 206, 86, 0.6)','rgba(75, 192, 192, 0.6)']";
    private $options = "plugins: {legend: {display: false}}";

    //set type of graph
    public function setType($type){
        $this->type = $type;
    }

    //show labels fo chart
    public function showLegend(){
        $this->options =  "plugins: {legend: {display: true}}";
    }
    //set Array of labels
    public function setLabels($labels){
        if(is_array($labels)){
            $this->data['labels'] = $labels;
        } elseif(is_string($labels)){
            array_push($this->data['labels'], $labels);
        } else{
            array_push($this->data['labels'], strval($labels));
        }
    }

    //set diagram label
    public function setDiagramLabel($labelName){
        $this->data['datasets']['label'] = $labelName;
    }

    //set data
    public function setData($dataset){
        
        if(is_numeric($dataset)){
            array_push($this->data['datasets']['data'], $dataset);
        } elseif(is_array($dataset)){
            $this->data['datasets']['data'] = $dataset;
        } else{
            array_push($this->data['datasets']['data'], floatval($dataset));
        } 
            
    }

    //get all labels names
    public function getLabels(){
        $str = '';
        foreach($this->data['labels'] as $label){
            $str.= '\''.$label.'\', ';
        }
        return $str;
    }

    //get all data
    public function getData(){
        $str = '';
        foreach($this->data['datasets']['data'] as $data){
            $str .= $data.',';
        }
        return $str;
    }


    public function generate(){
        return '{type: \''.$this->type.'\', data: { labels: ['.$this->getLabels().'], datasets: [{ label: \''.$this->data['datasets']['label'].'\', data: ['.$this->getData().'],'.$this->style.'}]},options:{'.$this->options.'}}';
    }

}
