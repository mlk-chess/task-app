<script setup>

const props = defineProps({
    id: {
        type: String,
        required: true
    }
})

</script>

<template>
    <input type="checkbox" :id="id" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">
                <slot name="header">
                    Hello!
                </slot>
            </h3>
            <slot name="content">
                <p class="py-4">Press ESC key or click the button below to close</p>
            </slot>
            <div class="modal-action">
                <!-- <label for="my_modal_6" class="btn">Close!</label> -->
                <slot name="actions"></slot>
            </div>
        </div>
    </div>
</template>