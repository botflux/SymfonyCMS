/**
 * Manage particles
 */
class Particles {
    /**
     * Initializes a new instance of Particles
     * @param config
     */
    constructor (config) {
        this.c = config
        this.e = document.querySelector(config.selector)
        this.szMin = Number.parseInt(this.e.getAttribute(config.sizeMinAttributeName))
        this.szMax = Number.parseInt(this.e.getAttribute(config.sizeMaxAttributeName))
        this.sp = this.e.getAttribute(config.speedAttributeName)
        this.ctx = this.e.getContext('2d')
        this.particles = []
        this.ts = 0

        this.init()
        window.addEventListener('resize', this.init.bind(this))
        requestAnimationFrame(this.animate.bind(this))
    }

    /**
     * Returns a random color based on the config
     */
    getRandomColor () {
        return this.c.particlesColors[Math.floor(Math.random() * this.c.particlesColors.length)]
    }

    /**
     * Moves and draws particles
     * @param ts the timestamp
     */
    animate (ts) {
        this.ctx.fillStyle = this.c.background
        this.ctx.fillRect(0,0, this.w, this.h)

        let et = ts - this.ts
        this.ts = ts

        let borderOffset = this.c.borderOffset

        for (let i = 0; i < this.count; i++) {
            this.particles[i].x += this.particles[i].speedX * et
            this.particles[i].y += this.particles[i].speedY * et

            if (this.particles[i].x > this.w + borderOffset) this.particles[i].x = -borderOffset
            else if (this.particles[i].x < -borderOffset) this.particles[i].x = this.w + borderOffset

            if (this.particles[i].y > this.h + borderOffset) this.particles[i].y = -borderOffset
            else if (this.particles[i].y < -borderOffset) this.particles[i].y = this.h + borderOffset

            this.ctx.fillStyle = this.particles[i].c
            this.ctx.strokeStyle = this.particles[i].c
            if (this.particles[i].isGlowing) {
                this.ctx.shadowBlur = 10
                this.ctx.shadowColor = this.particles[i].c
            } else {
                this.ctx.shadowBlur = 0
            }

            this.ctx.beginPath()
            if (this.particles[i].shape === 0){ // circle
                this.ctx.arc(this.particles[i].x, this.particles[i].y, this.particles[i].size, 0, 2 * Math.PI, !0)
                this.ctx.lineWidth = this.particles[i].size * .5
                this.ctx.stroke()
            }
            else if (this.particles[i].shape === 1) { // triangles
                this.ctx.moveTo(this.particles[i].x, this.particles[i].y)
                this.ctx.lineTo(this.particles[i].x + this.particles[i].size, this.particles[i].y)
                this.ctx.lineTo(this.particles[i].x, this.particles[i].y + this.particles[i].size)
                this.ctx.fill()
            } else if (this.particles[i].shape === 2) { // cross
                this.ctx.lineWidth = this.particles[i].size / 5
                this.ctx.moveTo(this.particles[i].x - this.particles[i].size / 2, this.particles[i].y)
                this.ctx.lineTo(this.particles[i].x + this.particles[i].size / 2, this.particles[i].y)
                this.ctx.stroke()
                this.ctx.moveTo(this.particles[i].x, this.particles[i].y - this.particles[i].size / 2)
                this.ctx.lineTo(this.particles[i].x, this.particles[i].y + this.particles[i].size / 2)
                this.ctx.stroke()
            } else if (this.particles[i].shape === 3) { // squares
                this.ctx.moveTo(this.particles[i].x, this.particles[i].y)
                this.ctx.lineTo(this.particles[i].size + this.particles[i].x, this.particles[i].y)
                this.ctx.lineTo(this.particles[i].size + this.particles[i].x, this.particles[i].y + this.particles[i].size)
                this.ctx.lineTo(this.particles[i].x, this.particles[i].y + this.particles[i].size)
                this.ctx.fill()
            }
        }

        requestAnimationFrame(this.animate.bind(this))
    }

    /**
     * Returns a number
     */
    getRandomShape () {
        return Math.round(Math.random() * 3)
    }

    /**
     * Creates all the particles
     */
    init () {
        this.w = this.e.parentElement.clientWidth
        this.h = this.e.parentElement.clientHeight
        this.e.width = this.w
        this.e.height = this.h
        this.count = Math.round(this.w * this.h * this.c.countFactor)

        for (let i = 0; i < this.count; i++) {
            this.particles = [...this.particles, ...[{
                x: Math.random() * this.w,
                y: Math.random() * this.h,
                size: Math.ceil(Math.random() * (this.szMax - this.szMin) + this.szMin) * (Math.random()<.1 ? 10 : 1),
                speedX: Math.random() * (this.sp - this.sp / 2),
                speedY: Math.random() * (this.sp - this.sp / 2),
                c: this.getRandomColor(),
                shape: this.getRandomShape(),
                isGlowing: (Math.random() < .9)
            }]]
        }
    }
}

new Particles({
    selector: '[data-particles]',
    sizeMaxAttributeName: 'data-particles-size-max',
    sizeMinAttributeName: 'data-particles-size-min',
    speedAttributeName: 'data-particles-speed',
    background: '#1d1d25',
    particlesColors: ['#17DC5F', '#FFDD00', '#00FFEE', '#D92953', '#5A02F3'],
    countFactor: .7e-5,
    borderOffset: 70
})

