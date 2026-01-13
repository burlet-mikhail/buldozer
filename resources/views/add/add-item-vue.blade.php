<add
    user="{{auth()->user()->id}}"
    viber="{{isset(auth()->user()?->messenger['viber']) ? auth()->user()->messenger['viber'] : null}}"
    whatsapp="{{isset(auth()->user()?->messenger['whatsapp']) ? auth()->user()->messenger['whatsapp'] : null}}"
    telegram="{{isset(auth()->user()?->messenger['telegram']) ? auth()->user()->messenger['telegram'] : null}}"
    phone="{{auth()->user()?->phone}}"
    name="{{auth()->user()?->name}}"></add>
