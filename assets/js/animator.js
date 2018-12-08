import { TweenLite, Power4, TimelineMax, Elastic } from 'gsap'

export class Animator {
    static playArticleAnimation (el) {
        TweenLite.fromTo(el, .2, {
            opacity: 0,
            transform: 'translate(-500px)'
        }, {
            opacity: 1,
            transform: 'translate(0)',
            ease: Power4.easeOut
        })
    }

    static playLandingAnimation (el) {
        let tl = new TimelineMax()
        tl
            .staggerFromTo(el.querySelectorAll('.landing__content > *'), .2, { opacity : 0, transform: 'translate(-200px)' }, { opacity: 1, transform: 'translate(0)', ease: Elastic.easeOut }, .2)
            .fromTo(el.querySelector('.landing__img'), .2, { opacity: 0}, { opacity: 1, ease: Power4.easeOut })
    }

    static playSkillCardAnimation (el) {
        TweenLite.to(el, .3, { opacity: 1, transform: 'scale(1)'})
    }

    static playLearningSubjectAnimation (el) {
        let tl = new TimelineMax()
        tl.staggerTo(el.querySelectorAll('.card'), .1, { transform: 'scale(1)', opacity: 1 }, .1)
    }
}