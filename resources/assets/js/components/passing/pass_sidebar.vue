<template>
  <div class="sidebar">
    <h3 class="sidebar__header">Список пройденных тестов</h3>
    <div class="sidebar-list">
      <div v-if="results.length>0" v-for="result in results">
        <h4>{{result.test.name}}</h4>
        <p>{{result['mark']}} баллов из {{result.test.maxmark}} возможных</p>
        <p>{{result['percent']}}% правильных овтетов</p>
      </div>
      <div v-if="results.length==0"> 
        <h4>Вы пока что не прошли ни одного теста</h4>
      </div>
    </div>
    <!-- <div id="#error">
      {{error}}
    </div> -->
  </div>

</template>
<script type="text/javascript">
  export default ({
    data: function(){
      return{
        results: [],
        b: '1',
        error: null
      };
    },
    created() {
      this.getTests();

    },
    methods: {
      switchMainView: function(view,ar = {}){
        this.$parent.switchMainView(view,ar);
      },
      getTests(){

        this.$http.get('/api/result')
          .then(function(response){
              this.results=response.data.results;
            },function(error){
              console.log(error.data);
              //this.error=$(error.data);
            });
      }
    },
    computed:{
    },
    watch:{
    }
  });
</script>