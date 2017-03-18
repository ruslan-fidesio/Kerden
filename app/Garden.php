<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GardenWeekPrices;
use Storage;
use Carbon;

class Garden extends Model
{
    public static $CATEGORIES = 
        ['Jardin'=>'Le Jardin',
         'Terrasse'=>'La Terrasse',
         'Domaine'=>'Le Domaine',
         'Jardin d\'hiver'=>'Le Jardin d\'hiver',
         'Jardin restaurant'=>'Le Jardin restaurant',
         'Château'=>'Le Château'];

    protected $fillable = ['title','blur_address','address','surface','max_pers','description'];


    public function prices(){
    	return $this->hasOne('App\GardenPrices','id');
    }

    public function owner(){
    	return $this->belongsTo('App\User','userid');
    }

    public function hours(){
        return $this->hasMany('App\GardenHour','garden_id');
    }

    public function getHours($weekDay){
        if($weekDay == 0) $weekDay = 7;
        return $this->hours->where('day',$weekDay)->first();
    }

    public function getMinPrice($date){
        if(empty($date)){
            return $this->prices->weekDay;
        }
        $carbDate = Carbon\Carbon::parse($date);
        if($carbDate->dayOfWeek == 5 || $carbDate->isWeekEnd()){
            return $this->prices->weekEnd;
        }
        return $this->prices->weekDay;
    }

    public function getFullBlurAddressAttribute(){
        if(substr( $this->blur_address ,0,2) =='75' ){
            $arr = intval( substr($this->blur_address, 3) );
            $arr=='1'? $arr.='er' : $arr.='ème';
            return 'Paris, '.$arr.' Arr.';
        }
        return $this->blur_address;
    }

    public function dispos(){
        return $this->hasMany('App\GardenDispo');
    }

    public function staff(){
        return $this->hasOne('App\GardenRequiredStaff','id');
    }

    public function location(){
        return $this->hasOne('App\GardenLocation','id');
    }

    public function activities(){
        return $this->hasOne('App\GardenActivity','id');
    }

    public function getAllowedActivitiesNumberAttribute(){
        $res = 0;
        foreach ($this->activities->getAttributes() as $key => $value) {
            if($key=='id') continue;
            if($value==1) $res ++;
        }
        return $res;
    }

    public function kitchen(){
        return $this->hasOne('App\GardenKitchen','id');
    }

    public function toilets(){
        return $this->hasOne('App\GardenToilets','id');
    }

    public function musicLevel(){
        return $this->hasOne('App\GardenMusicLevel','id');
    }

    public function gardenWare(){
        return $this->hasMany('App\GardenWare','id');
    }

    public function reservations(){
        return $this->hasMany('App\Reservation','garden_id');
    }

    public function commentaires(){
        return $this->hasMany('App\Commentaire');
    }

    public function defautImg(){
        return $this->hasOne('App\GardenDefaultImg');
    }

    public function animal(){
        return $this->hasOne('App\GardenAnimal');
    }

    public function guidelines(){
        return $this->hasMany('App\GardenGuideline');
    }

    public function locInfos(){
        return $this->hasMany('App\GardenLocInfo');
    }

    public function getPool(){
        foreach ($this->gardenWare as $key => $value) {
            if(explode('_',$value->type)[0] == 'Piscine'){
                return $value;
            }
        }
        return null;
    }

    public function getPhotosUrls(){
        if($this->defautImg){
            $array = Storage::files($this->id);
            usort($array, function ($a, $b) {
                if (explode('/',$a)[1] == $this->defautImg->file_name) return -1;
                if (explode('/',$b)[1] == $this->defautImg->file_name) return 1;
                return 0;
            });
            return $array;
        }
        return Storage::files($this->id);
    }

    public function getFirstPhotoURL(){
        if( count(Storage::files($this->id)) == 0 ) return null;
        if($this->defautImg){
            return $this->id.'/'.$this->defautImg->file_name;
        }
        return Storage::files($this->id)[0];
    }

    public function acceptNight($date){
        $carbDate = Carbon\Carbon::parse($date);
        $day = $carbDate->dayOfWeek == 0? 7 :$carbDate->dayOfWeek;
        $hours = $this->getHours($day);
        return ($hours->end_slot>22);
    }

    public function getSlots($date){
        $carbDate = Carbon\Carbon::parse($date);
        $day = $carbDate->dayOfWeek == 0? 7 :$carbDate->dayOfWeek;
        return $this->getSlotsByDay($day);
    }

    public function getHoursByDate($date){
        $carbDate = Carbon\Carbon::parse($date);
        return $this->getHours($carbDate->dayOfWeek);
    }

    // public function getSlotsByDay($day){
    //     $hours = $this->getHours($day);
    //     $res = [];
    //     if($hours->begin_slot == $hours->end_slot) return null;


    //     if($hours->begin_slot == 9 && $hours->end_slot >=22){
    //         if($hours->end_slot > 22) $res[] = 'all_day-night';
    //         else $res[] = 'all_day';
    //     }
    //     else{
    //         if($hours->begin_slot == 9) $res[] = 'morning';
    //         if( $hours->begin_slot <=14 && $hours->end_slot >14 ) $res[] ='afternoon';
    //         if( $hours->begin_slot <=18 && $hours->end_slot > 18){
    //             if( $hours->end_slot > 22) $res[] = 'evening-night';
    //             else $res[] = 'evening';
    //         } 
    //     }
    //     //if( $hours->end_slot > 22) $res[] = 'night';
    //     return $res;
    // }

    public function getSlotsByDay($day){
        $hours = $this->getHours($day);
        if( !$hours || ($hours->begin_slot == $hours->end_slot)) return null;

        if($hours->begin_slot == 9){
            if($hours->end_slot <= 14) return ['morning'];
            if($hours->end_slot == 18) return ['day'];
            if($hours->end_slot == 22) return ['all_day'];
            if($hours->end_slot > 22) return ['all_day-night'];
        }
        if($hours->begin_slot == 14){
            if($hours->end_slot <= 18) return ['afternoon'];
            if($hours->end_slot == 22) return ['late_day'];
            if($hours->end_slot > 22) return ['late_day-night'];
        }
        if($hours->begin_slot == 18){
            if($hours->end_slot <=22) return ['evening'];
            else return ['evening-night'];
        }else return ['night'];
    }

    public function acceptWeekDay($weekDay){
        if($weekDay == 0) $weekDay = 7;
        $hours = $this->getHours($weekDay);
        return ($hours->begin_slot != $hours->end_slot);
    }

    public function getAverageNoteAttribute(){
        if($this->commentaires->count() == 0) return -1;
        return round($this->commentaires->average('note')) / 2;
    }

    public function getAverageNoteAsFAStars(){
        $note = $this->averageNote;
        if($note == -1){
            return '';
        }
        $res = '';
        for($i=0; $i<5; $i++){
            if($i < $note){
                if($note-$i == 0.5){
                    $res .= '<i class="fa fa-star-half-o"></i>';
                }else{
                    $res .= '<i class="fa fa-star"></i>';
                }
            }else{
                $res .= '<i class="fa fa-star-o"></i>';
            }
        }
        return $res;
    }

    public function getBestCommentaireAttribute(){
        //return $this->commentaires->where('reported',0)->sortByDesc('note')->first();
        return $this->notReportedCommentaires->sortByDesc('note')->first();
    }

    public function getNotReportedCommentairesAttribute(){
        return $this->commentaires->where('reported',0)->merge($this->commentaires->where('ignore_report',1));
    }
}
