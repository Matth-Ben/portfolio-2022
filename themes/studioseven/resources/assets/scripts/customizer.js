wp.customize('blogname', (value) => {
  value.bind((to) => {
    const els = document.querySelectorAll('.brand')

    for (let i = 0; i < els.length; i++) {
      els[i].textContent = to
    }
  })
})
