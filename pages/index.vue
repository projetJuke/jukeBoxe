<script setup lang="ts">
const services = [
  {
    title: 'Creation de site vitrine',
    description: 'Une presence en ligne claire, rapide et pensee pour convertir les visiteurs en prospects.'
  },
  {
    title: 'Refonte et optimisation',
    description: 'Une structure modernisee, un contenu mieux organise et une navigation simplifiee.'
  },
  {
    title: 'SEO local',
    description: 'Des bases techniques propres pour aider votre site a etre indexe et trouve plus facilement.'
  }
]

const testimonials = [
  {
    quote: 'Le site etait en ligne rapidement, avec une structure claire et simple a faire evoluer.',
    name: 'Claire Martin',
    role: 'Consultante independante'
  },
  {
    quote: 'La base etait propre, les sections deja pensees, et les ajustements ont pris tres peu de temps.',
    name: 'Julien Bernard',
    role: 'Artisan'
  }
]

const faqItems = [
  {
    question: 'Combien de temps faut-il pour lancer un site vitrine ?',
    answer: 'Avec cette base, une premiere version peut etre preparee rapidement puis ajustee selon votre contenu et votre identite.'
  },
  {
    question: 'Puis-je faire evoluer les sections plus tard ?',
    answer: 'Oui. Les composants sont reutilisables et la structure permet d ajouter ou retirer des blocs sans refaire la page.'
  },
  {
    question: 'Le site est-il adapte au referencement ?',
    answer: 'Oui. La configuration inclut des meta SEO de base, un composant dedie, un robots.txt et un sitemap de demarrage.'
  }
]
</script>

<template>
  <div>
    <SeoPage
      title="Accueil"
      description="Modele de site vitrine Nuxt avec sections essentielles, composants reutilisables et bases SEO preconfigurees."
      path="/"
    />

    <SectionBlock
      id="hero"
      eyebrow="Template vitrine"
      title="Une base Nuxt prete a personnaliser pour les sites clients"
      description="Gagnez du temps avec une page d accueil deja structuree, des composants reutilisables et une configuration SEO de base."
      variant="hero"
    >
      <template #actions>
        <BaseButton href="#contact">
          Demander un devis
        </BaseButton>
        <BaseButton href="#services" variant="secondary">
          Voir les sections
        </BaseButton>
      </template>
    </SectionBlock>

    <SectionBlock
      id="services"
      eyebrow="Services"
      title="Des sections typiques deja pretes"
      description="Cette page couvre les besoins les plus frequents des sites vitrines et peut etre adaptee selon chaque client."
    >
      <ContentGrid :columns="3">
        <ServiceCard
          v-for="service in services"
          :key="service.title"
          :title="service.title"
          :description="service.description"
        />
      </ContentGrid>
    </SectionBlock>

    <SectionBlock
      id="about"
      eyebrow="Presentation"
      title="Une structure simple pour presenter votre activite"
      description="Expliquez votre valeur, votre methode et ce qui vous differencie sans repartir de zero a chaque projet."
      variant="muted"
    >
      <ContentGrid :columns="2">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
          <h3 class="text-xl font-semibold text-slate-900">
            Ce que cette base apporte
          </h3>
          <p class="mt-4 text-slate-600">
            Un design propre, une structure de contenu lisible, des appels a l action visibles et des composants faciles a recomposer.
          </p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-slate-900 p-8 text-slate-100 shadow-sm">
          <h3 class="text-xl font-semibold">
            Pour quels usages ?
          </h3>
          <p class="mt-4 text-slate-300">
            Artisans, independants, cabinets, studios, TPE ou associations qui ont besoin d un site vitrine professionnel et rapide a mettre en ligne.
          </p>
        </div>
      </ContentGrid>
    </SectionBlock>

    <TestimonialsSection :items="testimonials" />

    <FaqSection :items="faqItems" />

    <SectionBlock
      id="contact"
      eyebrow="Contact"
      title="Un formulaire deja integre"
      description="Ajoutez votre logique d envoi plus tard. La structure, les champs et le design sont deja en place."
      variant="muted"
    >
      <ContactForm />
    </SectionBlock>
  </div>
</template>
