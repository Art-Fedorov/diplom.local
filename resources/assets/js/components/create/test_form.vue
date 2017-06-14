<template>
  <div>
    <form id="test-form" @submit.prevent="setupTest()">
      <h2 class="text-center test__header">{{headerMessage}}</h2>
      <div class="form-group">
        <div class="col-md-4 col-sm-4 form-group__label">
          Название теста
        </div>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" type="text" autocomplete="false" name="name" 
          v-model="test.name" required/>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-4 col-sm-4 form-group__label">
          Описание теста
        </div>
        <div class="col-md-8 col-sm-8">
          <textarea class="form-control" id="desc" name="desc" type="text" autocomplete="false" rows="3" v-model="test.desc" ></textarea>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-4 col-sm-4 form-group__label">
          Категория
        </div>
        <div class="col-md-8 col-sm-8">
          <select class="form-control" name="id_alg" :disabled="test.id_alg" :title="test.id_alg?'После создания теста нельзя изменять его категорию':null" v-model="idAlgorithm">
            <option v-for="alg in algorithms" :value="alg.id" :selected="test.id_alg==alg.id?true:false">{{alg.name}}</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-4 col-sm-4 form-group__label">
          Максимальная оценка<br>
          (от 1 до 100)
        </div>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" type="number" min="1" max="100" id="maxmark"
           v-bind:value="test.maxmark||'25'" name="maxmark" required />
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-4 col-sm-4 form-group__label">
          Время на прохождение в формате ЧЧ:ММ:СС
        </div>
        <div class="col-md-8 col-sm-8">
          <input class="form-control" type="text" autocomplete="false" id="time" name="time" v-bind:value="test.time||'00:30:00'"/>
        </div>
      </div>
      <div class="form-group form-group--checkbox">
        <label for="shuffle_questions" class="col-md-5 col-sm-6 form-group__label">
          Перемешать порядок вопросов
        </label>
        <div class="col-md-7 col-sm-6">
          <div class="checkbox-container">
            <input type="checkbox" id="shuffle_questions" name="shuffle_questions" :checked="test.shuffle_questions||'true'">
            <label for="shuffle_questions" class="label-style"></label>
          </div>
          
        </div>
      </div>
      <div class="form-group form-group--checkbox">
        <label for="shuffle_answers" class="col-md-5 col-sm-6 form-group__label">
          Перемешать порядок ответов
        </label>
        <div class="col-md-7 col-sm-6">
          
          <div class="checkbox-container">
            <input type="checkbox" id="shuffle_answers" name="shuffle_answers" :checked="test.shuffle_answers||'true'">
            <label for="shuffle_answers" class="label-style"></label>
          </div>
        </div>
      </div>
      <div class="form-group form-group--checkbox" v-show="idAlgorithm==1">
        <label for="view_more_1_answer" class="col-md-5 col-sm-6 form-group__label">
          Показывать, если правильных вариантов ответа больше одного
        </label>
        <div class="col-md-7 col-sm-6">
          <div class="checkbox-container">
            <input type="checkbox" id="view_more_1_answer" name="view_more_1_answer" :checked="test.view_more_1_answer">
            <label for="view_more_1_answer" class="label-style"></label>
          </div>
          
        </div>
      </div>
      <div class="form-group form-group--checkbox" v-show="idAlgorithm==1">
        <label for="pass_other_questions" class="col-md-5 col-sm-6 form-group__label">
          Позволить произвольное перемещение по вопросам
        </label>
        <div class="col-md-7 col-sm-6">
          <div class="checkbox-container">
            <input type="checkbox" id="pass_other_questions" name="pass_other_questions" :checked="test.pass_other_questions">
            <label for="pass_other_questions" class="label-style"></label>
          </div>
          
        </div>
      </div>
      <div class="form-group form-group--checkbox">
        <label for="view_right_answers" class="col-md-5 col-sm-6 form-group__label">
          Показать правильные ответы после прохождения теста
        </label>
        <div class="col-md-7 col-sm-6">
          <div class="checkbox-container">
            <input type="checkbox" id="view_right_answers" name="view_right_answers" :checked="test.view_right_answers">
            <label for="view_right_answers" class="label-style"></label>
          </div>
        </div>
      </div>
      
      <!-- <div class="form-group form-group--checkbox">
        <label for="published" class="col-md-5 col-sm-6  form-group__label">
          Опубликовать?
        </label>
        <div class="col-md-7 col-sm-6">
          <div class="checkbox-container">
            <input type="checkbox" id="published" name="published" :checked="test.published">
            <label for="published" class="label-style"></label>
          </div>
          
        </div>
      </div> -->
      <input type="hidden" v-bind:value="idUser" name="id_user">
      <input type="hidden" name="id" v-bind:value="test.id">
      
      <div class="text-center">
        <button type="submit" class="btn btn-success">{{button}}</button>
      </div>
      <div class="extra__buttons" v-show="test.id">
        <button   class="btn btn-sm btn-primary"
                  @click.prevent="$parent.switchMainView('question-form',
                  { testId: test.id,
            title: 'add' })">
                  Добавить вопрос
        </button>
        <button class="btn btn-sm btn-primary" 
          @click.prevent="$parent.switchMainView('test-publish',
              { test: test })">Опубликовать тест
        </button>
        <button v-if="!test.published" 
                class="btn btn-sm btn-primary" 
          @click.prevent="$parent.deleteTest(test.id)">
        Удалить тест
        </button>
      </div>
    </form>
  </div>  
</template>
<script>

//import { VueEditor } from 'vue2-editor';
//import editor from 'vue2-medium-editor';

const popup = require('./popup.vue');
export default ({
  props: ['array'],
  data(){
    return {
      b: 0,
      algorithms: [],
      headerMessage: 'Создание теста',
      button: 'Создать тест',
      message: null,
      idAlgorithm: 1,
      test: {
        name: '',
        desc: '',
        time: '00:30:00',
        id_alg: null
      },
      idUser: this.$parent.$data.idUser,
      edited: false,
      route: null
    };
  },
  computed:{
    
  },
  created: function(){
    var self=this;//
    self.getUserId();
    self.getSingleTest();
    self.getAlgorithms();
    self.title = self.array.title?self.array.title:self.title;
    self.button = self.array.button?self.array.button:self.button;
    self.checkInscription();
  },
  watch: {
    array: function(val){
      this.checkInscription();
      this.test=val.test?val.test:{};
      this.title= val.title?val.title:this.title;
      this.button=val.button?val.button:this.button;
      this.getSingleTest();
    },
    b(val){
      this.b=val>1000?0:val;
    },
    test(val){
    },
  },
  methods: {
    getAlgorithms(){
      this.$http.get('api/algorithm').then(function(response){
          this.algorithms=response.data
        },function(error){
          //console.log(error.body);
        });
    },
    checkInscription(){
      if (this.array.title=='add'){
          this.headerMessage= "Добавление теста";
          this.button= "Добавить тест";
        } else if (this.array.title=='change'){
          this.headerMessage= "Изменение теста";
          this.button= "Изменить тест";
        }
    },
    //get test data
    getSingleTest: function(){
      if(this.array.id){
        this.route = '/api/test/'+this.array.id+'/edit';
        this.$http.get(this.route).then(function(response){
          this.test=response.data.edited;

        },function(error){
          console.log(error);
        });
        this.edited=true;
      } else{
        this.edited=false;
      }
    },
    getUserId(){
      this.$http.get('/api/user').then(function(response){
        this.idUser=response.data.id_user;
      },function(error){
        console.log(error);
      });
    },
    //update/create test
    setupTest: function(){
        let data= getFormData($('#test-form'));

        if (!checkTheTime(data.time)){
          alert('Неверный формат времени');
          return false;
        }
        if (this.edited){
          this.$http.put('/api/test/'+this.test.id, data).then(function(response) {
              this.test=response.data.data;
              this.$parent.showPopupDelay(1500);
              this.$parent.popup.header="Тест успешно обновлен";
              this.$parent.$refs.testSidebar.getTests();
          }, function(response) {
            // $('.error').append($.parseHTML(response.body));
            // console.log(response.body);
              console.log(response);
          });
        }
        else {     
          this.$http.post('/api/test', data).then(function(response) {
              this.test=response.data.data;

              this.edited=true;
              //console.log(response.data.data);
              this.$parent.showPopupDelay(2000);
              this.$parent.popup.header="Тест успешно создан";

              this.button="Изменить тест";
              this.title="Изменение теста";
              this.$parent.$refs.testSidebar.getTests();
              this.switchTestInfo();

          }, function(response) {
            // $('.error').append($.parseHTML(response.body));
            console.log(response.body);
          });
        }
      },
      //nulled messages of update or create
      nullAfter(ms){
        var self=this;
        setTimeout(function(){
          self.message=null; 
        },ms);
      },
      switchTestInfo(){
        this.$parent.switchMainView('test-info',
          {
            wasCreated: true,
            testId: this.test.id
          });
      },
      switchMainView: function(view,ar = {}){
        this.$parent.switchMainView(view,ar);
      }
  }
});
$(function() {
  
});
function getFormData($form){
    var unindexed_array = $form.serializeArray();
    $.each($($form).find('input[type=checkbox]')
      .filter(function(idx){
          return $(this).prop('checked') === false
      }),
      function(idx, el){
          // attach matched element names to the formData with a chosen value.
          unindexed_array.push({name:$(el).attr('name'),value:0});
      }
    );
    var indexed_array = {};
    $.map(unindexed_array, function(n, i){
        n['value']=n['value']=='on'?1:n['value'];
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}
function checkTheTime(str){
  if (str=="00:00:00") return false;
  console.log(str.match(/([01][0-9]||[2][0-3]):[0-5][0-9]:[0-5][0-9]/));
  return str.match(/([01][0-9]||[2][0-3]):[0-5][0-9]:[0-5][0-9]/);
}
</script>
