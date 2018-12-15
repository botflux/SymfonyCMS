const baseConfig = {
    buttonContainerSelector: '[data-magnetic]',
    buttonSelector: '[data-magnetic-button]',
    speed: .005
}

class MagneticButton {
    constructor (button, container, speedFactor) {
        this.button = button
        this.container = container
        this.speed = { x: 0, y: 0}
        this.client = { x: 0, y: 0}
        this.speedFactor = speedFactor
        this.lastTime = 0
        this.container.addEventListener ('mousemove', e => {
            this.client.x = e.clientX
            this.client.y = e.clientY

            let cRect = this.container.getBoundingClientRect()
            let bRect = this.button.getBoundingClientRect()

            if (this.client.x < cRect.x + bRect.width / 2
                || this.client.x > cRect.x + cRect.width - bRect.width / 2
                || this.client.y < cRect.y + bRect.height / 2
                || this.client.y > cRect.y + cRect.height - bRect.height / 2) {
                // out
                this.out()
            } else {
                // in
                this.in ()
            }
        })
        this.container.addEventListener ('mouseout', e => {
            this.setIn(false)
        })

        requestAnimationFrame(this.anim.bind(this))
    }

    anim (ts) {
        let delta = ts - this.lastTime
        this.lastTime = ts

        let bRect = this.button.getBoundingClientRect()
        let cRect = this.container.getBoundingClientRect()

        let dx = 0
        let dy = 0

        if (this.isIn) {
            dx = (this.client.x - (bRect.x + bRect.width / 2)) * this.speedFactor * delta
            dy = (this.client.y - (bRect.y + bRect.height / 2)) * this.speedFactor * delta
        } else {
            dx = this.speed.x * this.speedFactor * -1 * delta
            dy = this.speed.y * this.speedFactor * -1 * delta

            if (this.speed.x > -.1 && this.speed.x < .1) this.speed.x = 0
            if (this.speed.y > -.1 && this.speed.y < .1) this.speed.y = 0
        }

        this.addSpeed (dx, dy)
        this.button.style = this.getTransformString()
        requestAnimationFrame(this.anim.bind(this))
    }

    in () {
        this.setIn(true)
    }

    out () {
        this.setIn(false)
    }

    setIn (newState) {
        if (newState !== this.isIn) {
            this.isIn = newState
            if (this.handleStateChange) this.handleStateChange(newState)
        }
    }

    addSpeed (x, y) {
        this.speed.x += x
        this.speed.y += y
    }

    getTransformString () {
        return `transform: translate(${this.speed.x}px, ${this.speed.y}px)`
    }
}

class MagneticButtonManager {
    constructor (config = baseConfig) {
        this.magneticButtonContainers = document.querySelectorAll(config.buttonContainerSelector)

        this.magneticButtonContainers && this.magneticButtonContainers.forEach && this.magneticButtonContainers.forEach(c => {
            new MagneticButton(c.querySelector(config.buttonSelector), c, config.speed)
        })
    }
}

new MagneticButtonManager(baseConfig)

/*
new MagneticButton (
    document.querySelector('.btn'),
    document.querySelector('.btn-container'),
    .005
)*/

