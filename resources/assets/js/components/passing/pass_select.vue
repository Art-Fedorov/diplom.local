<template>
  <div class="select test-container-lg">
    <div class="container-md" v-if="tests.length>0">
      <h2 class="select__header">Доступные к прохождению тесты:</h2>
      <div class="test-container">
        <div class="select__item" v-for="test in tests">
          <div class="select__item-header h3">{{test.name}}</div>
          <div class="select__item-desc h4">{{test.desc}}</div>
          <a :href="'pass/test/'+test.id+'/start'" class="btn btn-success">Пройти тест</a>
        </div>
      </div>
    </div>
    <div class="container-md" v-else>
      <h3>Нет ни одного теста, доступного для прохождения</h3>
    </div>
  </div>
</template>
<script type="text/javascript">
  export default({
    data: function(){
      return{
        tests: [],
        b: '1'
      };
    },
    created() {
    this.getTests();

    },
    methods:{
      //ПЕРЕПИСАТЬ НА PHP
      getTests(){
        this.$http.get('/api/test')
          .then(function(response){
              var receivedTests=response.data.tests;
              this.$http.get('/api/result')
                .then(function(response1){
                    var receivedResults=response1.data.results;
                    let tests=[];
                    this.tests=[];
                    for (var test in receivedTests){
                      var f = false; 
                      if (receivedResults.length>0){
                        for (var result in receivedResults){
                          if (receivedTests[test].id==receivedResults[result].test.id) {
                            f=false;
                            break;
                          }
                          f=true;
                        }
                      } else {
                        f=true;
                      }
                      if (f) {
                        f=false;
                        if (receivedTests[test].published_at){
                          let date = receivedTests[test].published_at;
                          let year=date.split(' ')[0].split('-');
                          let time=date.split(' ')[1].split(':');
                          let finalDateStart=new Date(year[0],year[1]-1,year[2],time[0],time[1],time[2]);                    
                          if (receivedTests[test].published&&new Date()>finalDateStart) {
                            f=true;
                            if (receivedTests[test].ended_at){
                              let date = receivedTests[test].ended_at;
                              let year=date.split(' ')[0].split('-');
                              let time=date.split(' ')[1].split(':');
                              let finalDateEnd=new Date(year[0],year[1]-1,year[2],time[0],time[1],time[2]);
                              if (receivedTests[test].published&&new Date()<finalDateEnd) {

                                f=true;
                              } else {
                                f=false;
                              }
                            }
                          } else {
                            f=false;
                          }
                        }
                        
                      }
                      if (f) {
                        tests.push(receivedTests[test]);
                      }
                    }

                    for (var key in tests){
                      let f=true;
                      for (var k in tests[key].test_groups){
                        if(this.$parent.user.id_group==tests[key].test_groups[k].id_group){
                          f=false;
                          break;
                        }
                      }
                      if (f) tests.splice(key,1); 
                    }
                    this.tests=tests;      
                  },function(error){
                    console.log(error);
                   this.tests = [];
                  });
            },function(error){
              console.log(error.data);
            });
        
        
      },
    }
  });
</script>