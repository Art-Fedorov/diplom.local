<template>
  <transition name="modal">
    <div class="modal-bg">
      <div class="modal-mask" @click="$emit('closeN')">
      </div>
      <div class="modal-container text-center">
        <div class="modal-padding">
          <div class="modal-header">
            <slot name="header">
              Вы действительно хотите удалить этот элемент?
            </slot>
          </div>
          <div class="modal-body">
            <slot name="body">
            </slot>
          </div>
          <div class="modal-footer">
            <slot name="footer">
              <button  @click="$emit('closeY')">Да</button>
              <button  @click="$emit('closeN')">Нет</button>
            </slot>
          </div>
        </div> 
      </div>
      
    </div>
  </transition>
</template>
<script>
  export default ({
      data(){
        return {
          
        }
      },
      methods:{
      }
    });
</script>