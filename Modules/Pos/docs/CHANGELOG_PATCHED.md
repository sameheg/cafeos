# POS PATCH (Reservation, Payment, Inventory, Refund)

- Start Order: **ReservationGuard** enforced before إنشاء الطلب.
- Payment: **Recalc totals + Invoice + Loyalty** عند اكتمال الدفع.
- Add Item: يخصم **Inventory BOM** ويعيد حساب الإجماليات تلقائيًا.
- Refund: **صلاحيات إلزامية** + عكس مخزون لكل العناصر + **Audit**.
