---
name: trip-com-inspired-ui
description: Build travel, booking, and hospitality interfaces inspired by Trip.com's current visual language. Use when the user asks for Trip.com-like styling; adapt the pattern to the product rather than copying Trip.com branding.
---

# Trip.com-Inspired Interface

Use this guide as a reusable visual reference for travel and booking interfaces. The reference checked on 2026-10-23 was the Trip.com homepage, which resolved to the Vietnamese locale. Its styles and content can change; when exact current details matter, inspect the live page again.

## Visual Character

- Make the experience feel like a practical travel marketplace: clean, bright, information-dense, and easy to scan. Give search and booking actions priority over decoration.
- Use a white or very light neutral canvas with restrained blue as the main action color. The inspected homepage CSS repeatedly used `#3264FF` / `#2C61FE` blues, dark navy text such as `#0F294D`, white, and cool gray surfaces and borders. Treat these as starting references, not immutable brand tokens.
- Reserve red or warm accent colors for time-sensitive offers, discounts, or price emphasis. Do not let promotional colors compete with the primary action.
- Use real, relevant destination, hotel, or activity photography for content-led travel sections. Prefer clear, well-composed images that show the actual place or product. Keep imagery out of small controls and avoid purely atmospheric decoration.
- Keep sections aligned to a consistent content width and spacing rhythm. Use dividers, whitespace, and subtle cool-gray backgrounds to separate content; avoid excessive nested cards, heavy shadows, or ornamental gradients.

## Typography

- Trip.com serves its proprietary `Trip Geom` webfont on the inspected homepage, with regular, medium, and bold weights. The page's Vietnamese locale CSS instead sets a system sans-serif stack for body and all elements. Do not assume the proprietary font is available or licensed for another project.
- For Vietnamese interfaces, prioritize full Vietnamese glyph coverage. Use the existing product font when suitable; otherwise prefer a native/system sans stack such as `-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif`.
- If Trip Geom is explicitly available and permitted in the project, it may be used as a visual reference; do not download or bundle Trip.com's font assets without permission.
- Keep text hierarchy compact and functional: body copy is commonly around 14-16px with generous 1.5 line-height, secondary metadata 12-13px, controls at readable 14-16px, and section headings roughly 20-28px. Use larger display type only where the actual page structure calls for it.
- Use medium or bold weights for labels, prices, section headings, and selected states. Keep long descriptive content at regular weight for readability.

## Travel Search And Booking

- Put a prominent search module near the top of the page. Group service categories (for example hotels, flights, trains, cars, or activities) as tabs or a segmented control, then show the relevant fields for the selected category.
- Make field labels and values distinct. Use familiar date, guest, room, destination, and passenger controls; keep the main search action visually strongest.
- Keep the booking flow explicit: destination or route, dates, party size, filters, results, price, and the next action should be easy to understand without explanatory marketing copy.
- Use compact, scannable result rows or cards with a clear information order: image, name/location, rating or key details, cancellation/availability information when relevant, price, and action.
- Show price and value information with strong hierarchy, but do not fabricate discounts, ratings, availability, or urgency.
- On narrow screens, stack or collapse search fields without clipping labels. Preserve a clear primary action and make result cards readable without horizontal scrolling.

## Components And Interaction

- Use blue-filled buttons for primary actions and neutral or outlined treatments for secondary actions. Keep states for hover, focus, disabled, loading, selected, and error visually distinguishable.
- Use restrained borders and small corner radii (about 4-8px) for fields, buttons, and repeated result items. Avoid making every section a floating panel.
- Use icons only where they improve recognition, paired with text for less familiar actions. Keep icon sizing and alignment consistent.
- Make filters, sorting, date pickers, guest selectors, and tabs behave like controls, not decorative labels. Preserve keyboard focus and accessible names.
- Keep useful details visible in comparison views. Use badges sparingly for verified distinctions such as cancellation terms or promotion status.

## Responsive Behavior

- Keep the desktop experience dense but orderly, with aligned search fields and enough width for comparing products.
- At tablet and mobile widths, reflow multi-column search forms and result layouts into a clear vertical sequence. Keep prices and calls to action visible and prevent text/image overlap.
- Use stable image aspect ratios and reserved dimensions so cards do not jump while images load.
- Check at least one desktop and one narrow mobile viewport, including long Vietnamese labels and destination names.

## Adaptation Boundaries

- Reuse the visual principles, not Trip.com's name, logo, proprietary assets, exact copy, or trade dress. Apply the target product's own identity and content.
- Match the amount of density to the task: a simple booking page does not need every homepage module, service tab, promotion, or navigation item.
- Follow the existing project's framework, component library, and design conventions where they already exist. Keep this reference subordinate to explicit product requirements.
- Do not invent a particular section, font file, color token, or responsive breakpoint as an exact Trip.com standard unless verified in the live site or project source.
