<template>
    <inertia-head title="UnAuthorization" />
    <main-page>
        <div class="row mt-4">
            <div class="d-flex">
                <div class="card w-100">
                    <div class="card-body text-center mt-5 mb-5">
                        <img :src="`${$page.props.url}/images/unauthorization.png`" class="animate__animated animate__flipInX" alt="unautorization" style="height: 100px;width:auto;">
                        <h4 class="mt-4 animate__animated animate__flipInX">You Dose Note Have The Right Permissions.</h4>                    
                    </div>
                </div>
            </div>
        </div>
    </main-page>
</template>

<script setup>
</script>
