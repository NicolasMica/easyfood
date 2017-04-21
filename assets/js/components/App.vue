<style lang="scss" src="../../sass/app.scss"></style>

<template>
    <div>
        <h1>Button type</h1>
        <button class="btn">Default Button</button>
        <button class="btn indigo">Colored Button</button>
        <button class="btn-outline pink">Outline Button</button>
        <button class="btn-flat teal">Flat Button</button>
        <hr>
        <h1>Button shape</h1>
        <button class="btn circle">
            <i class="icon">code</i>
        </button>
        <button class="btn indigo">Default Button</button>
        <button class="btn raised pink">Raised Button</button>
        <button class="btn rounded teal">Rounded Button</button>
        <hr>
        <h1>Button icon</h1>
        <button class="btn">
            <i class="icon">code</i>
            Default Button
        </button>
        <button class="btn raised indigo">
            <i class="icon right">code</i>
            Default Button
        </button>
        <button class="btn-outline rounded pink">
            <i class="icon">code</i>
            Default Button
        </button>
        <button class="btn-flat teal">
            <i class="icon">code</i>
            <i class="icon right">code</i>
            Default Button
        </button>
        <hr>
        <h1>Button labeled</h1>
        <button class="btn labeled">
            <span class="label">Label</span>
            Default Button
        </button>
        <button class="btn raised indigo labeled">
            <span class="label">Label</span>
            Raised Button
        </button>
        <button class="btn-outline rounded pink labeled">
            <span class="label right">
                <i class="icon">code</i>
                Label
            </span>
            Rounded Button
        </button>
        <button class="btn-flat teal labeled">
            <span class="label">
                <i class="icon">code</i>
                Left
            </span>
            <span class="label right">
                <i class="icon right">code</i>
                Right
            </span>
            Flat Button
        </button>
        <hr>
        <h1>Button animation</h1>
        <button class="btn indigo">
            <i class="icon right animated slide-left">send</i>
            Send
        </button>
        <button class="btn-outline pink">
            <i class="icon animated spin">loop</i>
            Loading
        </button>
        <hr>
        <h1>Typography</h1>
        <div class="display-1">Display 1em</div>
        <div class="display-2">Display 2em</div>
        <div class="display-3">Display 3em</div>
        <div class="display-4">Display 4em</div>
        <hr>
    </div>
</template>

<script type="text/babel">
    export default {
    }
</script>