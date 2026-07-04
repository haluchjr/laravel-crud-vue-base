
<script setup>
defineProps({
    forId: {
        type: String,
        default: ''
    }
})
</script>
 
 <template>
    <label :for="forId" class="small text-muted mb-0">
        <slot/>
    </label>
 </template>