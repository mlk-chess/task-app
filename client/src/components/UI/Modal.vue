<script setup>

const props = defineProps({
    id: {
        type: String,
        required: true
    }
})

</script>

<template>
    <dialog :id="id" class="modal">
        <form method="dialog" class="modal-box">
            <h3 class="font-bold text-lg">
                <slot name="header">
                    Hello!
                </slot>
            </h3>
            <slot name="content">
                <p class="py-4">Press ESC key or click the button below to close</p>
            </slot>
            <div class="modal-action">
                <form method="dialog">
                    <slot name="actions"></slot>
                </form>
            </div>
        </form>
    </dialog>
</template>