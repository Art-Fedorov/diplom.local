<template>
  <transition name="modal">
    <div class="modal-bg">
      <div class="modal-mask" @click="$emit('close')">
      </div>
      <div class="modal-container text-center">
        <div class="modal-padding">
          <div class="modal-header">
            <slot name="header">
            </slot>
          </div>
          
          
            <slot name="body">
              
            </slot>
          
          
            <slot name="footer">
              <div class="modal-footer">
                <button class="modal-btn" @click="$emit('close')">Ок</button>
              </div>
            </slot>
          
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