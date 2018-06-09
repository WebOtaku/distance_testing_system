<template>

    <div class="authorization-form">

        <section class="section">

            <h1 class="title">Войти</h1>

            <h2 class="subtitle">Войти или <a href="/register">Зарегистрироваться</a></h2>

            <form method="POST" action="/login" class="form">

                <!--CSRF-FIELD-->
                <slot name="csrf"></slot>

                <div class="field">
                    <label class="label" for="email">E-mail</label>

                    <div class="control">
                        <input type="email" class="input" name="email" id="email" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="password">Пароль</label>

                    <div class="control">
                        <input type="password" class="input" name="password" id="password" required>
                    </div>
                </div>

                <!--ERRORS-->
                <slot name="errors"></slot>

                <button type="submit" class="button is-primary">Войти</button>

            </form>

        </section>

    </div>

</template>