import {
    BadgePercentIcon,
    BriefcaseBusiness,
    Heart,
    Hourglass,
    Mail,
    MapPin,
    MessageCircleQuestionMark,
    PackageSearchIcon,
    Phone,
    TagsIcon,
    Truck,
} from 'lucide-vue-next'

const benefits = [
    {
        icon: Truck,
        title: 'Livrare Rapidă',
        description: 'Livrăm în 24 de ore oriunde în țară',
        details: 'Livrare gratuită pentru comenzi peste 265 RON.',
    },
    {
        icon: Hourglass,
        title: 'Eleganță eternă',
        description: 'Buchetele noastre nu ofilesc niciodata!',
        details:
            'Spune adio florilor trecătoare – Fiecare buchet este creat pentru a rezista în timp, păstrându-și forma și farmecul fără grija ofilirii.',
    },
    {
        icon: Heart,
        title: 'Aranjamente Personalizate',
        description: 'Creăm buchete unice pentru tine',
        details:
            'Echipa noastră creează aranjamente personalizate pentru orice ocazie specială.',
    },
    {
        icon: MessageCircleQuestionMark,
        title: 'Disponibili 24/7 pentru tine',
        description: 'Comandă oricând, suport rapid',
        details:
            'Comandă în orice moment și primește ajutor rapid – suntem disponibili non-stop, pentru ca tu să te bucuri de cadourile tale fără griji.',
    },
]

const benefits_subscribe = [
    {
        icon: BadgePercentIcon,
        description: 'Cod de reducere 10% la abonare!',
    },
    {
        icon: PackageSearchIcon,
        description: 'Fii la curent cu ultimele produse!',
    },
    {
        icon: TagsIcon,
        description: 'Oferte speciale pentru abonați!',
    },
]

const utils_footer = [
    {
        name: 'Cum plătesc?',
        link: '/how-to-pay',
    },
    {
        name: 'Cum pot cumpăra?',
        link: '/how-to-buy',
    },
    { name: 'Întrebări frecvente', link: '/frequent-questions' },
    { name: 'Termeni și condiții ', link: '/terms-and-conditions' },
    {
        name: 'Protecția Datelor',
        link: '/privacy-policy',
    },
]

const links_t_footer = [
    {
        name: 'Tablouri Cartoon',
        link: '/categorie/tablouri-cartoon',
    },
]

const links_b_footer = [
    {
        name: 'Pentru mama',
        link: '/categorie/pentru-mama',
    },
    {
        name: "Valentine's Day",
        link: '/categorie/valentines-day',
    },
    {
        name: '8 Martie',
        link: '/categorie/8-martie',
    },
    {
        name: 'Pentru bunica',
        link: '/categorie/pentru-bunica',
    },
]

const contact_footer = [
    {
        icon: BriefcaseBusiness,
        title: 'CUI:',
        after_title: '51204668',
        description: 'J2025006385005',
    },
    {
        icon: MapPin,
        title: 'Adresă:',
        description: 'Bucuresti, Sector 5',
    },
    {
        icon: Phone,
        title: 'Telefon:',
        description: '+40 767 754 040',
    },
    {
        icon: Mail,
        title: 'Email:',
        description: 'satin.and.sweets@yahoo.com',
    },
]

export {
    benefits,
    benefits_subscribe,
    utils_footer,
    links_t_footer,
    links_b_footer,
    contact_footer,
}
