<template>
  <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">        
    <div class="pass-other">
      <div class="pass-other__header">
        <div class="q_mark" title="Вы можете пропускать вопросы и возвращаться к ним позже"></div>
        Перемещение по вопросам
      </div>
      <div class="pass-other__questions" v-if="tests.pass_other_questions">
        <span class="pass-other__item" v-for="question in tests.questions" @click="setCurrentQuestion(question.index)">
            {{(question.index+1)<10?'0'+(question.index+1):(question.index+1)}}
        </span>
      </div>
      <a href="" class="" @click.prevent="getResults()" title="У вас остались вопросы без ответа!">✖ Закончить тест</a>
    </div>
  </div>
</template>
<script type="text/javascript">
export default({
  props: ['test','questionsAnswers'],
  data(){
    return {
      tests: JSON.parse(this.test),
      results: {}

    };
  },
  methods:{
    
  },
  created(){
    this.getResult();
  }
});
</script>