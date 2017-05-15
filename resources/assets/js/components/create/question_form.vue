<template>

  <div class="test-container-lg" >
    <div class="test-container-md">
      <div class="question__button question__previous" v-if="checkShowPrevButton()">
        <button class="btn btn-sm btn-primary fa fa-arrow-left" @click.prevent="showPrevious"></button>
      </div>
      <div class="question__button question__next" v-if="checkShowNextButton()">
        <button class="btn btn-sm btn-primary fa fa-arrow-right"  @click.prevent="showNext"></button>
      </div>
      <h2 class="mb10 text-center">Тест "{{test.name}}"</h2>
      <h2 class="text-center">{{headerMessage}}</h2>
      <form @submit.prevent="setupQuestion()" id="question-form">  
        <!-- <div class="form-group">
          <div class="col-md-12 col-sm-12 text-left">
            Вопрос:
          </div>
        </div> -->
        <div class="form-group">
          <div class="col-md-12 col-sm-12">
            <!-- <textarea rows="3" class="form-control" type="text" autocomplete="false" name="question" 
            v-model="question.question" required/> -->
            <vue-editor
              ref="editor"
              :editor-toolbar="customToolbar"
              :value="question.question"
              v-model="question.question"
              :use-save-button="false">
            </vue-editor>
          </div>
        </div>
        <div class="preview ql-container" v-html="question.question">
          
        </div>
        <div class="form-group">
          <div class="col-md-3 col-sm-4 text-right form-group__label">
            Вес вопроса<br>(от 1 до 10)
          </div>
          <div class="col-md-9 col-sm-8">
            <input class="form-control" type="number" min="1" max="10" step="0.1" name="weight" 
            v-model="question.weight" required/>
          </div>
        </div>
        
        <div class="form-group" v-if="test.id_alg==1">
          <div class="col-md-3 col-sm-4 text-right form-group__label">
            Вид вопроса
          </div>
          <div class="col-md-9 col-sm-8">
            <select class="form-control" :disabled="question.id" :title="question.id?'После создания вопроса нельзя изменять его вид':null" name="word" id="word">
              <option value="0" :selected="!question.word">Варианты ответа</option>
              <option value="1" :selected="question.word">Слово/число</option>
            </select>
          </div>
        </div>
        <input type="hidden" :value="array.testId" name="id_test">
        <input type="hidden" :value="question.id" name="id">
        
        <div class="text-center">
          <button type="submit" class="btn btn-success">
          {{button}}
          </button>
          <p class="text-success">{{ questionMessage }}</p>
        </div>

        
      </form>
    </div>
    <div class="test-container-md" v-show="edited">
      <div v-if="!question.word">
        <h3>Варианты ответа</h3>
        <div class="answer">
        <div class="answer-item" v-for="(answer,index) in question.answers">
          <form :id="'answer-form'+index" :class="{'answer-form': test.id_alg!=2}" @submit.prevent="editAnswer(index)" >
            <div class="question__form-group">
              <div v-if="test.id_alg!=2" class="checkbox-container">
                <input type="checkbox"  name="iscorrect" :id="'iscorrect'+index"  :checked="answer.iscorrect?'on':null" />
                <label :for="'iscorrect'+index" class="label-style"></label>
              </div>
              <span v-show="false" v-else> <input type="hidden" name="iscorrect" value="1"></span>
              <input type="text" autocomplete="false" name="answer" id="answer" class="form-control question__form-control" v-model="answer.answer" required>
              
              
              <input type="hidden" :value="answer.id" name="id">
              <input type="hidden" :value="question.id_test" name="id_test">
              <button type="submit" class="btn btn-success">Обновить</button>
              <button class="question__icon fa fa-close" @click="deleteAnswer(answer.id)"></button>
            </div>
            <span>{{ answer.message }}</span>
          </form>
        </div>
        <form id="answer-form" :class="{'answer-form': test.id_alg!=2}" @submit.prevent="createAnswer()">
          <div class="question__form-group">
            <div v-if="test.id_alg!=2" class="checkbox-container">
              <input type="checkbox"  name="iscorrect" id="iscorrect" checked="1"/>
              <label for="iscorrect" class="label-style"></label>      
            </div>
            <span v-show="false" v-else> <input type="hidden" name="iscorrect" value="1"></span>
            <input type="text" autocomplete="false"name="answer" id="answer" class="form-control question__form-control" required>
            <input type="hidden" :value="question.id" name="id_question">
            <input type="hidden" :value="question.id_test" name="id_test">
            <button type="submit" class="btn btn-success">Сохранить</button>
          </div>
         
          <!-- <span>{{ answerCreateMessage }}</span> -->
          
        </form>
        </div>
      </div>
      <div v-else>
        <h3>Слово/число</h3>
        <form v-if="question.answers.length>0" id="answer-form0" @submit.prevent="editAnswer(0)">
          <div class="question__form-group">
            <input type="hidden" name="iscorrect" value="1">
            <input type="text" autocomplete="false"name="answer" id="answer" class="form-control question__form-control" v-model="question.answers[0].answer" required>
            <input type="hidden" :value="question.answers[0].id" name="id">
            <input type="hidden" :value="question.id" name="id_question">
            <input type="hidden" :value="question.id_test" name="id_test">
            <button type="submit" class="btn btn-success">Сохранить</button>
          </div>
          
          <!-- <span >{{ answerCreateMessage }}</span> -->
          
        </form>

        <form v-else id="answer-form" @submit.prevent="createAnswer()">
          <div class="question__form-group">
            <input type="hidden" name="iscorrect" value="1">
            <input type="text" autocomplete="false"name="answer" id="answer" class="form-control question__form-control" value="" required>
            <input type="hidden" :value="question.id" name="id_question">

            <input type="hidden" :value="question.id_test" name="id_test">
            <button type="submit" class="btn btn-success">Сохранить</button>
          </div>
          
          <!-- <span>{{ answerCreateMessage }}</span> -->
          
        </form>
      </div>
    </div>  
    <div class="extra__buttons" v-if="question.id">
      
      <div class="extra__button">
        <button @click.prevent="addNext" class="btn btn-sm btn-primary">Добавить следующий вопрос</button>
      </div>
      <div class="extra__button">
        <button @click.prevent="deleteQuestion" class="btn btn-sm btn-primary" >Удалить вопрос</button>
      </div>
      <!-- <div class="extra__button">
        <button @click.prevent="$parent.$refs.testSidebar.switchTestInfo(test)" class="btn btn-sm btn-primary">Просмотреть информацию о тесте</button>
      </div> -->
    </div>
  </div>
</template>
<script>
  





  import { VueEditor } from 'vue2-editor';

  export default({
    props: ['array'],
    components:{
      VueEditor,
    },
    data: function(){
      return {
        question: {
          id: this.array.id||null,
          question: "",
          weight: 1,
          answers: [],
        },
        customToolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            ['image'],

            [{ 'list': 'ordered'}, { 'list': 'bullet' }],

            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

            [{ 'color': [] }, { 'background': [] }],
            [{ 'font': [] }],

            ['clean']
          ],
        test: {},
        length: 0,
        route: null,
        headerMessage: "Добавление вопроса",
        button: "Добавить вопрос",
        messages:{
          up: 'Запись успешно обновлена',
          qCreate: 'Вопрос успешно добавлен',
        },
        questionMessage: null,
        edited: false,
        indexPrev: null,
        indexNext: null,
        b: 0,
      }
    },


    created : function(){
      this.getTest();
      this.checkInscription();
      this.getSingleQuestion();
      this.b++;
    },


    watch: {
      array: function(val){
        this.onArrayChange(val);
      },
      question(val){
        this.$nextTick(function(){

          this.checkAlgorythm();
        });
      }
    },

    mounted(){

    },

    computed:{
    },

    methods: {
      onArrayChange(val){
        let that=this;
        that.question={};
        that.question.question=val.question?val.question:"";
        that.question.id= val.id||null;
        that.question.testId= val.testId||null;
        that.getTest();
        that.getSingleQuestion();
        that.checkInscription();
      },

      getTest(){
        this.$http.get('/api/test/'+this.array.testId).then(function(response) {
            this.b++;
            this.test=response.data.test;
            //console.log(response.data);
          }, function(response) {
              
          }); 
      },
      addNext(){
        this.$parent.switchMainView('question-form',
                { testId: this.array.testId,
                  title: 'add', question: "" });
        this.onArrayChange({ testId: this.array.testId,
                  title: 'add', question: "" });
      },
      checkShowPrevButton(){
        for (var key in this.test.questions){
          if (this.test.questions[key].id==this.question.id){
            if (key>0){
              this.indexPrev=key-1;
              return true;
            }
            this.indexPrev=null;
            return false;
          } 
        }
      },
      checkShowNextButton(){
        for (var key in this.test.questions){
          if (this.test.questions[key].id==this.question.id){
            if (parseInt(key)+1<this.test.questions.length){
              this.indexNext=parseInt(key)+1;
              return true;
            }
            this.indexNext=null;
            return false;
          }
        }
      },
      showPrevious(){
        if (this.indexPrev!=null) {
          this.$parent.switchMainView('question-form',
                { testId: this.test.id,
                  id: this.test.questions[this.indexPrev].id,
                  title: 'change' });
        }
      },
      showNext(){
        if (this.indexNext!=null) {
          this.$parent.switchMainView('question-form',
                { testId: this.test.id,
                  id: this.test.questions[this.indexNext].id,
                  title: 'change' });
        }
      },
      checkInscription(){
        if (this.array.title=='add'){
          this.headerMessage= "Добавление вопроса";
          this.button= "Добавить вопрос";
        } else if (this.array.title=='change'){
          this.headerMessage= "Изменение вопроса";
          this.button= "Изменить вопрос";
        }
      },
      checkAlgorythm(){
        if (this.test.id_alg==2) {
          let checkboxes=$('[id*="iscorrect"][type="checkbox"]');
          checkboxes.each(function(){
            $(this).attr('disabled',true);
            $(this).prop('checked', true).attr('checked','checked');
          });
        }
      },
      //get question data
      getSingleQuestion: function(){
        if (this.question.id){
          var that=this;
          this.route = '/api/question/'+this.question.id+'/edit';
          this.$http.get(this.route).then(function(response){

            
            
            that.$nextTick(function(){
              that.question=response.data.edited;
              that.checkAlgorythm();
            });
          },function(error){
            console.log(error);
          });
          that.edited=true;
        } else{
          this.question.question="";
          this.edited=false;
        }

      },

      //update or create question
      setupQuestion: function(){
        let that=this;
        let data= getFormData($('#question-form'));
        let x = that.$refs.editor.editor.innerHTML.replace(/<\/?[^>]+>/g,'').replace(/\s+/,"");
        if (x.length<=5){
          alert('Введите вопрос длинною более 5 символов!');
          return false;
        }

        that.question.question=that.$refs.editor.editor.innerHTML;
        data.question=that.question.question;
        if (that.edited){
          that.$http.put('/api/question/'+that.question.id, data).then(function(response) {


            that.$parent.showPopupDelay(1500);
            that.$parent.popup.header="Вопрос успешно изменен";

            that.$parent.$refs.testSidebar.getTests();
          }, function() {
              console.log('failed');
          });
        }
        else {
          
          that.$http.post('/api/question', data).then(function(response) {

            that.$parent.showPopupDelay(1500);
            that.$parent.popup.header="Вопрос успешно добавлен";

            that.edited=true;
            that.headerMessage='Изменение вопроса';
            that.button='Изменить вопрос';
            that.question=response.data.data;
            that.$parent.$refs.testSidebar.getTests();
          }, function(response) {
              //console.log(response.data);
          });
        }
        
        
      },
      createAnswer(){
        let form='#answer-form ';
        let data= getFormData($(form));
        //console.log(data);
        this.$http.post('/api/answer', data).then(function(response) {
            this.question.answers.push(response.data.data);
            this.$parent.showPopupDelay(1200);
            this.$parent.popup.header="Ответ успешно добавлен";
          }, function() {
              console.log('failed');
          });
        $(form).find('[name="answer"]').val(null);
        if (this.test.id_alg!=2&&this.question.word==0){
          $(form).find('[name="iscorrect"]').prop('checked',false);
        }
      },
      deleteQuestion(){
        if (confirm('Вы действительно хотите удалить вопрос?')){
          this.$parent.$refs.testSidebar.deleteQuestion(this.question.id,this.test);
          this.$parent.$refs.testSidebar.switchTestInfo(this.test);
        }    
      },
      editAnswer(index){
        let form='#answer-form'+index+' ';
        let data= getFormData($(form));
        //console.log(data);
        this.$http.put('/api/answer/'+data.id, data).then(function(response) {
              this.$parent.showPopupDelay(1200);
              this.$parent.popup.header="Ответ успешно изменен";
          }, function() {
              console.log('failed');
          });
      },
      
      deleteAnswer(id){
        this.$http.delete('/api/answer/'+id).then(function(response) {
              var self=this;
              self.question.answers = self.question.answers.filter(function( obj ) {
                return obj.id !== id;
              });

              this.$parent.showPopupDelay(1200);
              this.$parent.popup.header="Вариант ответа успешно удален";
              self.b++;
          }, function() {
              console.log('failed');
          });

      },
    }
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
</script>
