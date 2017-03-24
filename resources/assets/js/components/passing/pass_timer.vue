<template>
  <div class="timer"><span class="timer__text">Времени осталось:</span> <span class="timer__time" title="По окончании действия таймера прохождение теста завершится">{{time}}</span></div>
</template>
<script type="text/javascript">
  export default({
    props: ['test','timer'],
    data(){
      return{
        tests: this.test,
        time: this.test.time
      }
    },
    created(){
     
      var self=this;
      
      self.time="00:00:08";
      self.time=self.tests.time;
      self.checkDiff();
      var timerId = setInterval(function(){
        self.setTimer(self.time);
        if (self.time=="00:00:00") {
          clearInterval(timerId);
          self.$parent.passed=true;
        }
      },1000);
    },
    methods:{
      setTimer(){
        let self=this;
        let timeArray=self.time.split(':');
        let h = timeArray[0];
        let m = timeArray[1];
        let s = timeArray[2];
        if (s == 0) {
          if (m == 0) {
            h--;
            m = 60;
            if (h < 10) h = "0" + h;
          }
          m--;
          if (m < 10) m = "0" + m;
          s = 59;
        }
        else s--;
        if (s < 10) s = "0" + s;
        self.time=h+":"+m+":"+s; 
      },
      checkDiff(){
        let self=this;
        let all = self.stringToSeconds(self.time);
        if (all<self.timer){
          self.$parent.passed=true;
        } else {
          self.time=self.secondsToString(all-self.timer);
        }
      },
      secondsToString(sec){
        let h=Math.floor(sec/3600);
        h=h<10?'0'+h:h;
        sec-=h*3600;
        let m=Math.floor(sec/60);
        m=m<10?'0'+m:m;
        sec-=m*60;
        let s=Math.floor(sec);
        s=s<10?'0'+s:s;
        sec-=s;
        sec=h+':'+m+':'+s;
        return sec;
      },
      stringToSeconds(str){
        var arr=str.split(':');
        return parseInt(arr[0]*3600)+parseInt(arr[1]*60)+parseInt(arr[2]);
      }
    }
  });
</script>