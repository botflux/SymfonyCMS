import ScrollOut from 'scroll-out'
import {Animator} from "./animator";

Animator.playHeaderLinkAnimation()

ScrollOut({
    targets: '[data-scroll]',
    once: true,
    threshold: .45,
    onShown (el) {
        if (el.classList.contains('article')) {
            Animator.playArticleAnimation(el)
        } else if (el.classList.contains('landing')) {
            Animator.playLandingAnimation(el)
        } else if (el.classList.contains('card')) {
            Animator.playSkillCardAnimation(el)
        } else if (el.classList.contains('card-holder--tiles')) {
            Animator.playLearningSubjectAnimation(el)
        } else if (el.classList.contains('text')) {
            Animator.playTextAnimation(el)
        }
    }
})